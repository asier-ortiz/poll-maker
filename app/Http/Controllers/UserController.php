<?php

namespace App\Http\Controllers;

use App\Models\AccountPoll;
use App\Models\Answer;
use App\Models\Poll;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

class UserController extends Controller
{
    private PollController $pollController;

    public function __construct()
    {
        $this->middleware('auth');
        $this->pollController = new PollController();
    }

    public function index(Request $request): Factory|View|Application
    {
        $request->user()->authorizeRole('user');
        $user = $request->user();
        $invitations = $this->getInvitations($user);
        $alreadyAnsweredPollsIds = $this->getPollsIdssAlreadyAnswered($user);
        $pollsInWhichUserTakingPart = $user
            ->invitations()
            ->wherePivot('accepted', true)->get()
            ->where('endDate', '>=', now());
        return view('users.index', [
            'invitations' => $invitations,
            'pollsInWhichUserTakingPart' => $pollsInWhichUserTakingPart,
            'alreadyAnsweredPollsIds' => $alreadyAnsweredPollsIds
        ]);
    }

    public function show(Request $request, $id): Factory|View|Application
    {
        $request->user()->authorizeRole('user');
        $user = $request->user();
        $poll = Poll::find($id);
        $answers = $poll->answers;
        if ($poll->accountPolls->isEmpty()) {
            $answerId = null;
        } else {
            $answerId = $poll->accountPolls
                ->where('poll_id', $poll->id)
                ->where('user_id', $user->id)
                ->pluck('answer_id')[0] ?? null;
        }
        $noAnswerCount = $this->pollController->countAccountPollsNoAnswerByPoll($poll);
        return view('users.show', compact('poll', 'answers', 'noAnswerCount', 'answerId'));
    }

    public function addPoll(Request $request): Redirector|Application|RedirectResponse
    {
        $request->user()->authorizeRole('user');
        $this->validate($request,
            ['code' => 'required'],
            ['code.required' => 'El campo código no puede estar vacío']
        );
        $code = request('code');
        $id = Poll::where('code', $code)->get('id');
        $request->user()->invitations()->updateExistingPivot($id, ['accepted' => true]);
        return redirect(route('users.index'));
    }

    public function search(Request $request): Factory|View|Application
    {
        $request->user()->authorizeRole('user');
        $user = $request->user();
        $invitations = $this->getInvitations($user);
        $alreadyAnsweredPollsIds = $this->getPollsIdssAlreadyAnswered($user);
        $code = $request->get('poll_code');
        $question = $request->get('poll_question');
        $public = $request->get('poll_public');
        switch ($public) {
            case'all':
                $public = 'public in (1,0)';
                break;
            case 'active':
                $public = 'public = 1';
                break;
            case 'inactive';
                $public = 'public = 0';
                break;
        }
        $q = $public;
        $polls = $user
            ->invitations()
            ->where('code', 'like', '%' . $code . '%')
            ->where('question', 'like', '%' . $question . '%')
            ->whereRaw($q)
            ->where('endDate', '>=', now())
            ->wherePivot('accepted', true)->get();
        return view('users.index', [
            'invitations' => $invitations,
            'pollsInWhichUserTakingPart' => $polls,
            'alreadyAnsweredPollsIds' => $alreadyAnsweredPollsIds
        ]);
    }

    public function pollAnswersList($id): Factory|View|Application
    {
        $poll = Poll::find($id);
        return view('users.form_vote', ['poll' => $poll]);
    }

    public function vote(Request $request): Redirector|Application|RedirectResponse
    {
        $request->user()->authorizeRole('user');
        $user = $request->user();
        $this->validate($request,
            ['answer' => 'required'],
            ['answer.required' => 'Por favor, escoja una opción']
        );
        $poll_id = $request->get('poll');
        $answer = Answer::find($_POST['answer'][0]);
        $vote = new AccountPoll([
            'user_id' => $user->id,
            'poll_id' => $poll_id,
            'answer_id' => $answer->id
        ]);
        $vote->save();
        $user->accountPolls()->save($vote);
        Poll::find($poll_id)->accountPolls()->save($vote);
        $answer->accountPolls()->save($vote);
        return redirect(route('users.index'));
    }

    public function getInvitations($user)
    {
        return $user->invitations->where('endDate', '>=', now());
    }

    public function getPollsIdssAlreadyAnswered($user)
    {
        return $user->accountPolls->pluck('poll_id')->toArray();
    }
}

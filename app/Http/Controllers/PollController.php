<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Poll;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;

class PollController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request): Factory|View|Application
    {
        $request->user()->authorizeRole('creator' || 'admin');
        $polls = Poll::orderBy('startDate', 'desc')->paginate(5);
        return view('polls.index', ['polls' => $polls]);
    }

    public function create(Request $request): Factory|View|Application
    {
        $request->user()->authorizeRole('creator');
        $code = $this->getRandomCode();
        $startDate = now();
        $endDate = now()->modify('+3 days');
        return view('polls.create', ['code' => $code, 'startDate' => $startDate, 'endDate' => $endDate]);
    }

    public function store(Request $request): Redirector|Application|RedirectResponse
    {
        $request->user()->authorizeRole('creator');
        $creator = $request->user();
        $this->validate($request,
            [
                'startDate' => 'required|after_or_equal:today',
                'endDate' => 'required|after:startDate',
                'question' => 'required',
                'code' => 'required',
                'answer.*' => 'required|distinct'
            ],
            [
                'startDate.required' => 'El campo fecha inicio es obligatorio',
                'startDate.after_or_equal' => 'La fecha de inicio no puede ser anterior a ' . date('d/m/Y', strtotime(now())),
                'endDate.required' => 'El campo fecha fin es obligatorio',
                'endDate.after' => 'La fecha de fin ha de ser posterior a la fecha de inicio',
                'question.required' => 'El campo pregunta es obligatorio',
                'answer.*' => 'Los campos respuesta son obligatiorios y han de ser distintos'
            ]
        );
        $answers = $_POST['answer'];
        $poll = new Poll([
            'startDate' => request('startDate'),
            'endDate' => request('endDate'),
            'question' => request('question'),
            'code' => request('code'),
            'public' => $request->has('public'),
            'published' => false,
            'user_id' => $creator->id
        ]);
        $poll->save();
        foreach ($answers as $answer) {
            $newAnswer = new Answer([
                'answer' => $answer,
                'poll_id' => $poll->id
            ]);
            $newAnswer->save();
            $poll->answers()->save($newAnswer);
            $newAnswer->poll()->associate($poll)->save();
        }
        return redirect(route('polls.index'));
    }

    public function show(Request $request, Poll $poll): Factory|View|Application
    {
        $request->user()->authorizeRole('creator' || 'admin');
        $answers = $poll->answers;
        $accountPolls = $poll->accountPolls;
        $noAnswerCount = $this->countAccountPollsNoAnswerByPoll($poll);
        return view('polls.show', compact('poll', 'answers', 'accountPolls', 'noAnswerCount'));
    }

    public function edit(Request $request, Poll $poll): Factory|View|Application
    {
        $request->user()->authorizeRole('creator');
        return view('polls.edit', compact('poll'));
    }

    public function update(Request $request, Poll $poll): Redirector|Application|RedirectResponse
    {
        $request->user()->authorizeRole('creator');
        $this->validate($request,
            [
                'startDate' => 'required|after_or_equal:today',
                'endDate' => 'required|after:startDate',
                'question' => 'required',
                'code' => 'required',
                'answer.*' => 'required|distinct'
            ],
            [
                'startDate.required' => 'El campo fecha inicio es obligatorio',
                'startDate.after_or_equal' => 'La fecha de inicio no puede ser anterior a ' . date('d/m/Y', strtotime(now())),
                'endDate.required' => 'El campo fecha fin es obligatorio',
                'endDate.after' => 'La fecha de fin ha de ser posterior a la fecha de inicio',
                'question.required' => 'El campo pregunta es obligatorio',
                'answer.*' => 'Los campos respuesta son obligatiorios y han de ser distintos'
            ]
        );
        $poll->update([
            'startDate' => request('startDate'),
            'endDate' => request('endDate'),
            'question' => request('question'),
            'public' => $request->has('public'),
        ]);
        if ($request->submit == 'Publish') {
            $poll->update([
                'published' => true
            ]);
        }
        $answers = $_POST['answer'];
        $poll->answers()->delete();
        foreach ($answers as $answer) {
            $updatedAnswer = new Answer([
                'answer' => $answer,
                'poll_id' => $poll->id
            ]);
            $updatedAnswer->save();
            $poll->answers()->save($updatedAnswer);
            $updatedAnswer->poll()->associate($poll)->save();
        }
        return redirect(route('polls.index'));
    }

    public function destroy(Request $request, Poll $poll): Redirector|RedirectResponse|Application
    {
        $request->user()->authorizeRole('creator');
        try {
            $poll->delete();
        } catch (Exception $e) {
            return back();
        }
        return redirect(route('polls.index'));
    }

    public function userInvitationsList($id): Factory|View|Application
    {
        $poll = Poll::find($id);
        $users = User::all()
            ->where('role', 'user')
            ->diff($poll->invitations);
        return view('polls.form_invitations', ['users' => $users, 'poll' => $poll]);
    }

    public function sendInvitations(Request $request): Redirector|Application|RedirectResponse
    {
        $request->user()->authorizeRole('creator');
        $ids = $request->input('invite');
        $poll = Poll::find($request->input('poll'));
        foreach ($ids as $id) {
            $user = User::find($id);
            $user->invitations()->attach($poll->id);
        }
        return redirect(route('polls.index'));
    }

    public function search(Request $request): Factory|View|Application
    {
        $request->user()->authorizeRole('creator' || 'admin');
        $code = $request->get('poll_code');
        $question = $request->get('poll_question');
        $public = $request->get('poll_public');
        $published = $request->get('poll_published');
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
        switch ($published) {
            case'all':
                $published = 'published in (1,0)';
                break;
            case 'active':
                $published = 'published = 1';
                break;
            case 'inactive';
                $published = 'published = 0';
                break;
        }
        $rawQuery = $public . ' and ' . $published;
        $polls = Poll::where('code', 'like', '%' . $code . '%')
            ->where('question', 'like', '%' . $question . '%')
            ->whereRaw($rawQuery)
            ->paginate(5);
        return view('polls.index', ['polls' => $polls]);
    }

    public function countAccountPollsNoAnswerByPoll(Poll $poll): Collection
    {
        return $poll->accountPolls()
            ->groupBy('answer_id')
            ->select('answer_id', DB::raw('count(*) as total'))
            ->where('poll_id', $poll->id)
            ->get();
    }

    private function getRandomCode(): string
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        $valid = false;
        while (!$valid) {
            for ($i = 0; $i < 5; $i++) {
                $randomString .= $characters[rand(0, strlen($characters) - 1)];
            }
            if (Poll::where('code', null, $randomString)->doesntExist()) {
                $valid = true;
            } else {
                $randomString = '';
            }
        }
        return $randomString;
    }
}

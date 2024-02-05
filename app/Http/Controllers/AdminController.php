<?php

namespace App\Http\Controllers;

use App\Models\Poll;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Validation\ValidationException;

class AdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request): Factory|View|Application
    {
        $request->user()->authorizeRole('admin');
        $users = User::orderBy('role')->paginate(5);
        return view('admins.index', ['users' => $users]);
    }

    public function showUser(Request $request, $id): Factory|View|Application
    {
        $request->user()->authorizeRole('admin');
        $user = User::find($id);
        $pollsCreatedByTheUser = Poll::where('user_id', $id)->get('*');
        $pollsInWhichUserTakingPart = User::find($id)
            ->invitations()
            ->wherePivot('accepted', true)->get();
        return view('admins.show_user',
            [
                'user' => $user,
                'pollsInWhichUserTakingPart' => $pollsInWhichUserTakingPart,
                'alreadyAnsweredPollsIds' => [],
                'pollsCreatedByTheUser' => $pollsCreatedByTheUser
            ]);
    }

    public function searchUsers(Request $request): Factory|View|Application
    {
        $request->user()->authorizeRole('admin');
        $name = $request->get('user_name');
        $email = $request->get('user_email');
        $role = $request->get('user_role');
        switch ($role) {
            case'all':
                $users = User::where('name', 'like', '%' . $name . '%')
                    ->where('email', 'like', '%' . $email . '%')
                    ->get('*')
                    ->sortBy('role');
                break;
            case 'admin':
                $users = User::where('name', 'like', '%' . $name . '%')
                    ->where('email', 'like', '%' . $email . '%')
                    ->where('role', 'like', '%' . 'admin' . '%')
                    ->get('*');
                break;
            case 'creator';
                $users = User::where('name', 'like', '%' . $name . '%')
                    ->where('email', 'like', '%' . $email . '%')
                    ->where('role', 'like', '%' . 'creator' . '%')
                    ->get('*');
                break;
            case 'user';
                $users = User::where('name', 'like', '%' . $name . '%')
                    ->where('email', 'like', '%' . $email . '%')
                    ->where('role', 'like', '%' . 'user' . '%')
                    ->get('*');
                break;
        }
        return view('admins.index', ['users' => $users]);
    }

    public function promote(Request $request): Redirector|RedirectResponse|Application
    {
        $request->user()->authorizeRole('admin');
        try {
            $this->validate($request,
                ['role' => 'required']
            );
        } catch (ValidationException $e) {
            return back();
        }
        $role = request('role');
        User::find($request->input('user'))->update([
            'role' => $role
        ]);
        return redirect(route('admins.index'));
    }
}

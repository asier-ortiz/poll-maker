<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\PollController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('/auth/login');
});

Route::get('/admins/user/{id}', [AdminController::class, 'showUser'])->name('admins.showUser');
Route::post('/admins/searchUsers', [AdminController::class, 'searchUsers'])->name('admins.searchUsers');
Route::put('/admins', [AdminController::class, 'promote'])->name('admins.promote');
Route::resource('admins', AdminController::class);

Route::post('/polls/search', [PollController::class, 'search'])->name('polls.search');
Route::get('/polls/{id}/invitations', [PollController::class, 'userInvitationsList'])->name('polls.userInvitationsList');
Route::post('/polls/{id}/invitations', [PollController::class, 'sendInvitations'])->name('polls.sendInvitations');
Route::resource('polls', PollController::class);

Route::post('/users/search', [UserController::class, 'search'])->name('users.search');
Route::get('/users/vote/{id}', [UserController::class, 'pollAnswersList'])->name('users.pollAnswersList');
Route::put('/users/vote/{id}', [UserController::class, 'vote'])->name('users.vote');
Route::put('/users', [UserController::class, 'addPoll'])->name('users.addPoll');
Route::resource('users', UserController::class);

Auth::routes();


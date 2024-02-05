<?php

namespace Database\Seeders;

use App\Models\AccountInvitations;
use App\Models\AccountPoll;
use App\Models\Answer;
use App\Models\Poll;
use App\Models\User;
use Illuminate\Database\Seeder;

class AccountPollSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all()->where('role', null, 'user');
        $polls = Poll::all()->where('published', null, 1);

        foreach ($polls as $poll) {
            foreach ($users as $user) {

                AccountPoll::factory()->create([
                    'user_id' => $user->id,
                    'poll_id' => $poll->id,
                    'answer_id' => Answer::all()->where('poll_id', null, $poll->id)->random()
                ]);

                AccountInvitations::factory()->create([
                    'user_id' => $user->id,
                    'poll_id' => $poll->id,
                    'accepted' => true
                ]);

            }
        }
    }
}

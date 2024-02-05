<?php

namespace Database\Seeders;

use App\Models\Answer;
use App\Models\Poll;
use Illuminate\Database\Seeder;

class AnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $polls = Poll::all();

        foreach ($polls as $poll) {
            for ($i = 0; $i < 5; $i++) {

                Answer::factory()->create([
                    'poll_id' => $poll->id
                ]);

            }
        }
    }
}

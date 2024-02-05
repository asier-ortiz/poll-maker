<?php

namespace Database\Seeders;

use App\Models\Poll;
use App\Models\User;
use Illuminate\Database\Seeder;

class PollSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $creators = User::all()->where('role', null, 'creator');

        foreach ($creators as $creator) {
            for ($i = 0; $i < 5; $i++) {

                Poll::factory()->create([
                    'user_id' => $creator->id
                ]);

            }
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@test.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'role' => 'admin',
            'remember_token' => Str::random(10),
        ]);

        User::factory()->create([
            'name' => 'creator',
            'email' => 'creator@test.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'role' => 'creator',
            'remember_token' => Str::random(10),
        ]);

        User::factory()->create([
            'name' => 'user',
            'email' => 'user@test.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'role' => 'user',
            'remember_token' => Str::random(10),
        ]);

        for ($i = 0; $i <= 7; $i++) {
            if ($i == 7) {

                User::factory()->create([
                    'role' => 'admin'
                ]);

            } elseif ($i == 5 || $i == 6) {

                User::factory()->create([
                    'role' => 'creator'
                ]);

            } else {

                User::factory()->create();
            }
        }
    }
}

<?php

namespace Database\Factories;

use App\Models\Poll;
use Illuminate\Database\Eloquent\Factories\Factory;

class PollFactory extends Factory
{

    protected $model = Poll::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'startDate' => now(),
            'endDate' => now()->modify('+3 days'),
            'question' => $this->faker->sentence(10),
            'code' => $this->faker->unique()->regexify('[A-Z0-9]{' . mt_rand(5, 5) . '}'),
            'public' => $this->faker->boolean(50),
            'published' => $this->faker->boolean(50),
        ];
    }
}

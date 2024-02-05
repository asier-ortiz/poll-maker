<?php

namespace Database\Factories;

use App\Models\Answer;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnswerFactory extends Factory
{

    protected $model = Answer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'answer' => $this->faker->sentence(5)
        ];
    }
}

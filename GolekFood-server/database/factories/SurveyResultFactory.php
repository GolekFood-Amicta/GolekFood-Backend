<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SurveyResult>
 */
class SurveyResultFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'umur' => rand(12,60),
            'hasil' =>  fake()->randomElement(['Diet', 'Bulking', 'Other']),
        ];
    }
}

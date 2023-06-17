<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Favourite>
 */
class FavouriteFactory extends Factory
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
            'user_id' => rand(1,5),
            'foodname' => fake()->firstName() . 'food',
            'fat' => rand(1,1000),
            'protein' => rand(1,1000),
            'carbohydrate' => rand(1,1000),
            'calories' => rand(1,1000),
            
        ];
    }
}

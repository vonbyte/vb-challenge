<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Training>
 */
class TrainingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'expirationPeriod' => fake()->biasedNumberBetween(1,5),
            'expiresEndOfMonth' => fake()->boolean(50),
            'expiresNever' => fake()->boolean(50),
            'renevalPeriod' => fake()->biasedNumberBetween(1,20),
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Emplacement;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Emplacement>
 */
class EmplacementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'zone' => fake()->randomElement(['A', 'B', 'C', 'D', 'E', 'F']),
            'allee' => (string) fake()->numberBetween(1, 10),
            'occupe' => false,
        ];
    }
}

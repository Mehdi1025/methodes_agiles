<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nom' => fake('fr_FR')->lastName(),
            'prenom' => fake('fr_FR')->firstName(),
            'email' => fake('fr_FR')->unique()->safeEmail(),
            'telephone' => fake('fr_FR')->phoneNumber(),
            'adresse_livraison' => fake('fr_FR')->address(),
        ];
    }
}

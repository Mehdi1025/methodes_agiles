<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Colis;
use App\Models\Transporteur;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Colis>
 */
class ColisFactory extends Factory
{
    /**
     * Descriptions réalistes de colis.
     */
    protected static array $descriptions = [
        'Matériel électronique',
        'Vêtements',
        'Livre',
        'Pièces détachées automobile',
        'Cosmétiques',
        'Équipement sportif',
        'Jouets',
        'Mobilier',
        'Instruments de musique',
        'Outillage',
        'Textile',
        'Produits alimentaires',
        'Médicaments',
        'Documents',
        'Accessoires informatiques',
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $statut = fake()->randomElement(['reçu', 'en_stock', 'en_expédition', 'livré', 'retour']);
        $dateReception = fake()->dateTimeBetween('-30 days', 'now');
        $dateExpedition = $this->getDateExpeditionLogique($statut, $dateReception);

        return [
            'code_qr' => 'COL-' . fake()->unique()->numerify('########'),
            'description' => fake()->randomElement(self::$descriptions),
            'poids_kg' => fake()->randomFloat(2, 0.5, 30.0),
            'dimensions' => fake()->numberBetween(10, 80) . 'x' . fake()->numberBetween(10, 60) . 'x' . fake()->numberBetween(5, 50),
            'statut' => $statut,
            'date_reception' => $dateReception,
            'date_expedition' => $dateExpedition,
            'fragile' => fake()->boolean(20),
            'client_id' => Client::factory(),
            'transporteur_id' => Transporteur::factory(),
        ];
    }

    /**
     * Calcule une date d'expédition logique selon le statut.
     */
    protected function getDateExpeditionLogique(string $statut, \DateTimeInterface $dateReception): ?\DateTimeInterface
    {
        return match ($statut) {
            'livré', 'en_expédition' => fake()->dateTimeBetween($dateReception, 'now'),
            'retour' => fake()->optional(0.7)->dateTimeBetween($dateReception, 'now'),
            'en_stock', 'reçu' => fake()->optional(0.3)->dateTimeBetween('now', '+14 days'),
            default => null,
        };
    }
}

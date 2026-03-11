<?php

namespace Database\Factories;

use App\Models\Colis;
use App\Models\HistoriqueMouvement;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<HistoriqueMouvement>
 */
class HistoriqueMouvementFactory extends Factory
{
    /**
     * Statuts possibles pour les mouvements.
     */
    protected static array $statuts = ['reçu', 'en_stock', 'en_expédition', 'livré', 'retour'];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'colis_id' => Colis::factory(),
            'user_id' => User::factory(),
            'ancien_statut' => null,
            'nouveau_statut' => 'reçu',
            'date_mouvement' => now(),
            'commentaire' => fake('fr_FR')->optional(0.5)->sentence(),
        ];
    }

    /**
     * Mouvement de réception (premier mouvement).
     */
    public function reception(\DateTimeInterface $date): static
    {
        return $this->state(fn () => [
            'ancien_statut' => null,
            'nouveau_statut' => 'reçu',
            'date_mouvement' => $date,
        ]);
    }

    /**
     * Mouvement de transition vers un nouveau statut.
     */
    public function transition(?string $ancienStatut, string $nouveauStatut, \DateTimeInterface $date): static
    {
        return $this->state(fn () => [
            'ancien_statut' => $ancienStatut,
            'nouveau_statut' => $nouveauStatut,
            'date_mouvement' => $date,
        ]);
    }
}

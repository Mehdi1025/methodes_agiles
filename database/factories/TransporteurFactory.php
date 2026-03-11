<?php

namespace Database\Factories;

use App\Models\Transporteur;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Transporteur>
 */
class TransporteurFactory extends Factory
{
    /**
     * Les 5 transporteurs connus avec leurs URLs de tracking.
     */
    protected static array $transporteursConnus = [
        ['nom' => 'DHL', 'contact' => 'https://www.dhl.com/fr-fr/home/tracking.html'],
        ['nom' => 'Chronopost', 'contact' => 'https://www.chronopost.fr/tracking-no-cms/tracking'],
        ['nom' => 'UPS', 'contact' => 'https://www.ups.com/track'],
        ['nom' => 'FedEx', 'contact' => 'https://www.fedex.com/fr-fr/tracking.html'],
        ['nom' => 'La Poste', 'contact' => 'https://www.laposte.fr/outils/suivre-vos-envois'],
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $transporteur = fake()->randomElement(self::$transporteursConnus);

        return [
            'nom' => $transporteur['nom'],
            'contact' => $transporteur['contact'],
            'delai_moyen_jours' => fake()->numberBetween(1, 5),
        ];
    }

    /**
     * Créer un transporteur avec des données fixes spécifiques.
     *
     * @return array<string, mixed>
     */
    public static function getTransporteurConnu(string $nom): array
    {
        $transporteur = collect(self::$transporteursConnus)->firstWhere('nom', $nom);

        return [
            'nom' => $transporteur['nom'],
            'contact' => $transporteur['contact'],
            'delai_moyen_jours' => fake()->numberBetween(1, 5),
        ];
    }

    /**
     * Liste des noms des 5 transporteurs connus.
     *
     * @return array<string>
     */
    public static function getNomsTransporteursConnus(): array
    {
        return array_column(self::$transporteursConnus, 'nom');
    }
}

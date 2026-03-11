<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Colis;
use App\Models\Emplacement;
use App\Models\HistoriqueMouvement;
use App\Models\Transporteur;
use App\Models\User;
use Database\Factories\TransporteurFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Descriptions réalistes de colis.
     */
    protected array $descriptionsColis = [
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
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Utilisateurs fixes
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@entrepots.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $logistique1 = User::factory()->create([
            'name' => 'Logistique 1',
            'email' => 'logistique1@entrepots.com',
            'password' => Hash::make('password'),
            'role' => 'logistique',
        ]);

        $logistique2 = User::factory()->create([
            'name' => 'Logistique 2',
            'email' => 'logistique2@entrepots.com',
            'password' => Hash::make('password'),
            'role' => 'logistique',
        ]);

        $utilisateursLogistique = [$logistique1, $logistique2];

        // 2. Clients
        $clients = Client::factory(15)->create();

        // 3. Transporteurs (5 transporteurs connus)
        $transporteurs = collect(TransporteurFactory::getNomsTransporteursConnus())
            ->map(fn (string $nom) => Transporteur::create(
                TransporteurFactory::getTransporteurConnu($nom)
            ))
            ->all();

        // 4. Emplacements
        $emplacements = Emplacement::factory(50)->create();

        // 5. Colis avec logique métier
        for ($i = 0; $i < 50; $i++) {
            $statut = fake()->randomElement(['reçu', 'en_stock', 'en_expédition', 'livré', 'retour']);
            $dateReception = fake()->dateTimeBetween('-30 days', 'now');
            $dateExpedition = $this->getDateExpeditionLogique($statut, $dateReception);

            $emplacementId = null;
            if ($statut === 'en_stock') {
                $emplacementDisponible = $emplacements->first(fn (Emplacement $e) => ! $e->occupe);
                if ($emplacementDisponible) {
                    $emplacementId = $emplacementDisponible->id;
                    $emplacementDisponible->update(['occupe' => true]);
                }
            }

            $colis = Colis::create([
                'code_qr' => 'COL-' . fake()->unique()->numerify('########'),
                'description' => fake()->randomElement($this->descriptionsColis),
                'poids_kg' => fake()->randomFloat(2, 0.5, 30.0),
                'dimensions' => fake()->numberBetween(10, 80) . 'x' . fake()->numberBetween(10, 60) . 'x' . fake()->numberBetween(5, 50),
                'statut' => $statut,
                'date_reception' => $dateReception,
                'date_expedition' => $dateExpedition,
                'fragile' => fake()->boolean(20),
                'client_id' => $clients->random()->id,
                'transporteur_id' => fake()->randomElement($transporteurs)->id,
                'emplacement_id' => $emplacementId,
            ]);

            // 6. HistoriqueMouvement (1 ou 2 lignes par colis)
            $userLogistique = fake()->randomElement($utilisateursLogistique);

            // Premier mouvement : réception
            HistoriqueMouvement::create([
                'colis_id' => $colis->id,
                'user_id' => $userLogistique->id,
                'ancien_statut' => null,
                'nouveau_statut' => 'reçu',
                'date_mouvement' => $dateReception,
                'commentaire' => fake('fr_FR')->optional(0.4)->sentence(),
            ]);

            // Deuxième mouvement (50% de chances) : transition vers le statut actuel
            if (fake()->boolean(50) && $statut !== 'reçu') {
                $dateSecondMouvement = fake()->dateTimeBetween($dateReception, 'now');

                HistoriqueMouvement::create([
                    'colis_id' => $colis->id,
                    'user_id' => fake()->randomElement($utilisateursLogistique)->id,
                    'ancien_statut' => 'reçu',
                    'nouveau_statut' => $statut,
                    'date_mouvement' => $dateSecondMouvement,
                    'commentaire' => fake('fr_FR')->optional(0.4)->sentence(),
                ]);
            }
        }
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

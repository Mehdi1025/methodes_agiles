<?php

namespace App\Http\Controllers;

use App\Models\Colis;
use App\Models\Emplacement;
use App\Models\Transporteur;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class StatisticController extends Controller
{
    /**
     * Affiche le centre d'analyse logistique ultra-dense.
     */
    public function index(): View
    {
        // Volume global
        $totalColis = Colis::count();
        $colisLivresMois = Colis::where('statut', 'livré')
            ->whereMonth('date_expedition', now()->month)
            ->whereYear('date_expedition', now()->year)
            ->count();
        $colisEnTransit = Colis::where('statut', 'en_expédition')->count();

        // Tendance vs mois dernier (pour badge)
        $colisLivresMoisDernier = Colis::where('statut', 'livré')
            ->whereMonth('date_expedition', now()->subMonth()->month)
            ->whereYear('date_expedition', now()->subMonth()->year)
            ->count();
        $tendanceMois = $colisLivresMoisDernier > 0
            ? round((($colisLivresMois - $colisLivresMoisDernier) / $colisLivresMoisDernier) * 100)
            : 0;

        // Performance : Délai moyen expédition (heures entre réception et expédition)
        $colisAvecDates = Colis::whereNotNull('date_reception')
            ->whereNotNull('date_expedition')
            ->get();
        $delaiMoyenHeures = $colisAvecDates->isNotEmpty()
            ? $colisAvecDates->avg(fn ($c) => $c->date_reception->diffInHours($c->date_expedition))
            : 24;
        $delaiMoyenExpedition = $delaiMoyenHeures >= 24
            ? round($delaiMoyenHeures / 24, 1) . ' j'
            : round($delaiMoyenHeures, 1) . ' h';

        // Taux de livraison à l'heure : colis livrés / (colis livrés + retards) — simulé si vide
        $colisLivres = Colis::where('statut', 'livré')->count();
        $colisRetard = Colis::whereNotNull('date_expedition')
            ->where('date_expedition', '<', now()->startOfDay())
            ->where('statut', '!=', 'livré')
            ->count();
        $denominateur = $colisLivres + $colisRetard;
        $tauxLivraisonHeure = $denominateur > 0
            ? round(($colisLivres / $denominateur) * 100, 1)
            : 95.0;

        // Taux de retour
        $colisRetour = Colis::where('statut', 'retour')->count();
        $tauxRetour = $totalColis > 0
            ? round(($colisRetour / $totalColis) * 100, 1)
            : 0;

        // Santé entrepôt (reçu + en_stock = colis physiquement en entrepôt)
        $poidsTotalStock = (float) (Colis::whereIn('statut', ['en_stock', 'reçu', 'en_preparation'])
            ->selectRaw('COALESCE(SUM(poids_kg), 0) as total')->value('total') ?? 0);
        $valeurEstimeeStock = $totalColis > 0 ? $totalColis * 15 : 0; // ~15€/colis simulé
        $colisFragiles = Colis::where('fragile', true)->count();
        $pourcentageFragile = $totalColis > 0
            ? round(($colisFragiles / $totalColis) * 100, 1)
            : 0;

        // Occupation par zone (A, B, C)
        $zoneRaw = Emplacement::select('zone', DB::raw('count(*) as total'), DB::raw('sum(occupe) as occupes'))
            ->groupBy('zone')
            ->get()
            ->keyBy('zone');
        $occupationParZone = collect(['A', 'B', 'C'])->map(function ($zone) use ($zoneRaw) {
            $row = $zoneRaw->get($zone);
            $pct = $row && $row->total > 0 ? (int) round(((int) $row->occupes / (int) $row->total) * 100) : 0;
            return (object) ['zone' => $zone, 'pourcentage' => $pct];
        });

        // Top transporteurs avec volume et taux de succès
        $topTransporteurs = Transporteur::withCount('colis')
            ->withCount(['colis as colis_livres_count' => function ($q) {
                $q->where('statut', 'livré');
            }])
            ->having('colis_count', '>', 0)
            ->orderByDesc('colis_count')
            ->limit(6)
            ->get()
            ->map(function ($t) {
                $tauxSucces = $t->colis_count > 0
                    ? round(($t->colis_livres_count / $t->colis_count) * 100, 1)
                    : 0;
                return (object) [
                    'nom' => $t->nom,
                    'volume' => $t->colis_count,
                    'taux_succes' => $tauxSucces,
                    'statut' => $tauxSucces >= 90 ? 'excellent' : ($tauxSucces >= 70 ? 'bon' : 'attention'),
                ];
            });

        // Répartition par statuts
        $statutsMapping = [
            'reçu' => 'Reçu',
            'en_stock' => 'En stock',
            'en_expédition' => 'En expédition',
            'livré' => 'Livré',
            'retour' => 'Retour',
            'alerte' => 'Alerte',
        ];
        $repartitionStatuts = Colis::select('statut', DB::raw('count(*) as total'))
            ->groupBy('statut')
            ->get()
            ->map(function ($r) use ($statutsMapping, $totalColis) {
                $pct = $totalColis > 0 ? round(($r->total / $totalColis) * 100, 1) : 0;
                return (object) [
                    'label' => $statutsMapping[$r->statut] ?? $r->statut,
                    'total' => $r->total,
                    'pourcentage' => $pct,
                ];
            })
            ->sortByDesc('total')
            ->values();

        return view('statistics.index', compact(
            'totalColis',
            'colisLivresMois',
            'colisEnTransit',
            'tendanceMois',
            'delaiMoyenExpedition',
            'tauxLivraisonHeure',
            'tauxRetour',
            'poidsTotalStock',
            'valeurEstimeeStock',
            'pourcentageFragile',
            'occupationParZone',
            'topTransporteurs',
            'repartitionStatuts'
        ));
    }

    /**
     * Télécharge le rapport en CSV.
     */
    public function exportCsv(): StreamedResponse
    {
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="rapport-logistique-' . now()->format('Y-m-d') . '.csv"',
        ];

        return response()->streamDownload(function () {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF)); // BOM UTF-8

            fputcsv($handle, ['Indicateur', 'Valeur', 'Unité'], ';');
            fputcsv($handle, ['Total colis', Colis::count(), 'unités'], ';');
            fputcsv($handle, ['Colis livrés (mois)', Colis::where('statut', 'livré')->whereMonth('date_expedition', now()->month)->count(), 'unités'], ';');
            fputcsv($handle, ['Colis en transit', Colis::where('statut', 'en_expédition')->count(), 'unités'], ';');
            fputcsv($handle, ['Poids total stock', Colis::whereIn('statut', ['en_stock', 'reçu', 'en_preparation'])->selectRaw('COALESCE(SUM(poids_kg), 0) as total')->value('total') ?? 0, 'kg'], ';');

            fclose($handle);
        }, 'rapport-logistique-' . now()->format('Y-m-d') . '.csv', $headers);
    }
}

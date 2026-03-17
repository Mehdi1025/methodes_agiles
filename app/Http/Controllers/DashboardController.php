<?php

namespace App\Http\Controllers;

use App\Models\Colis;
use App\Models\Emplacement;
use App\Models\HistoriqueMouvement;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Vide le cache système et optimise l'application.
     */
    public function clearCache(): RedirectResponse
    {
        Artisan::call('optimize:clear');

        return back()->with('success', '🧹 Cache système vidé et application optimisée avec succès.');
    }

    /**
     * Affiche le tableau de bord selon le rôle et le mode (Avancé / Terrain).
     */
    public function __invoke(): View
    {
        if (auth()->user()->role === 'admin') {
            return $this->adminDashboard();
        }

        if (session('mode') === 'simple') {
            return $this->dashboardSimple();
        }

        return $this->logistiqueDashboard();
    }

    /**
     * Dashboard Mode Terrain (ergonomique, mobile-first, touch-friendly).
     */
    protected function dashboardSimple(): View
    {
        $lastColis = null;
        if ($lastId = session('last_scanned_colis_id')) {
            $lastColis = Colis::with('client')->find($lastId);
        }

        $colisEnSouffrance = Colis::with('client')
            ->whereNotIn('statut', ['livré', 'en_expédition', 'anomalie'])
            ->where('created_at', '<=', now()->subHours(24))
            ->orderBy('created_at')
            ->get();

        return view('dashboard-simple', compact('lastColis', 'colisEnSouffrance'));
    }

    /**
     * Dashboard pour les magasiniers (rôle logistique).
     */
    protected function logistiqueDashboard(): View
    {
        $enStock = Colis::whereIn('statut', ['en_stock', 'reçu', 'en_preparation'])->count();
        $enExpedition = Colis::where('statut', 'en_expédition')->count();
        $livresMois = Colis::where('statut', 'livré')
            ->whereMonth('date_expedition', now()->month)
            ->whereYear('date_expedition', now()->year)
            ->count();

        // Tendances réelles : réceptions ce mois vs mois précédent
        $receptionsCeMois = Colis::whereIn('statut', ['en_stock', 'reçu', 'en_preparation'])
            ->whereMonth('date_reception', now()->month)
            ->whereYear('date_reception', now()->year)
            ->count();
        $receptionsMoisPrec = Colis::whereIn('statut', ['en_stock', 'reçu', 'en_preparation'])
            ->whereMonth('date_reception', now()->subMonth()->month)
            ->whereYear('date_reception', now()->subMonth()->year)
            ->count();
        $tendanceEnStock = $receptionsMoisPrec > 0
            ? round((($receptionsCeMois - $receptionsMoisPrec) / $receptionsMoisPrec) * 100)
            : ($receptionsCeMois > 0 ? 100 : null);

        $livresMoisPrec = Colis::where('statut', 'livré')
            ->whereMonth('date_expedition', now()->subMonth()->month)
            ->whereYear('date_expedition', now()->subMonth()->year)
            ->count();
        $tendanceLivres = $livresMoisPrec > 0
            ? round((($livresMois - $livresMoisPrec) / $livresMoisPrec) * 100)
            : ($livresMois > 0 ? 100 : null);

        $tendanceExpedition = null; // Pas de tendance fiable pour expédition en cours

        $alertes = Colis::whereNotNull('date_expedition')
            ->where('date_expedition', '<', now()->startOfDay())
            ->where('statut', '!=', 'livré')
            ->count();

        $derniersColis = Colis::with('client')
            ->orderByDesc('date_reception')
            ->limit(5)
            ->get();

        $colisFragilesEnRetard = Colis::where('fragile', true)
            ->whereNotNull('date_expedition')
            ->where('date_expedition', '<', now()->startOfDay())
            ->where('statut', '!=', 'livré')
            ->count();

        // Watchdog : colis en souffrance (statut ni livré, ni expédié, ni anomalie, créés il y a +24h)
        $colisEnSouffrance = Colis::with('client')
            ->whereNotIn('statut', ['livré', 'en_expédition', 'anomalie'])
            ->where('created_at', '<=', now()->subHours(24))
            ->orderBy('created_at')
            ->get();

        $totalEmplacements = Emplacement::count();
        $emplacementsOccupes = Emplacement::where('occupe', true)->count();
        $tauxOccupation = $totalEmplacements > 0
            ? (int) round(($emplacementsOccupes / $totalEmplacements) * 100)
            : 0;

        $poidsTotal = (float) (Colis::whereIn('statut', ['en_stock', 'reçu', 'en_preparation'])
            ->selectRaw('COALESCE(SUM(poids_kg), 0) as total')->value('total') ?? 0);
        $colisFragiles = Colis::whereIn('statut', ['en_stock', 'reçu', 'en_preparation'])->where('fragile', true)->count();
        $tauxRetours = Colis::where('statut', 'retour')->count();

        // Stats par statut (pour donut)
        $statsStatuts = Colis::selectRaw('statut, count(*) as total')
            ->groupBy('statut')
            ->pluck('total', 'statut')
            ->toArray();

        // Évolution hebdomadaire : colis créés par jour (7 derniers jours)
        $evolutionHebdo = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $count = Colis::whereDate('created_at', $date)->count();
            $evolutionHebdo[] = [
                'label' => $date->locale('fr')->translatedFormat('D'),
                'total' => $count,
            ];
        }

        // KPIs avancés
        $poidsMois = (float) Colis::whereMonth('date_reception', now()->month)
            ->whereYear('date_reception', now()->year)
            ->sum('poids_kg');
        $totalColis = Colis::count();
        $colisExpedies = Colis::whereNotNull('date_expedition')->count();
        $tauxExpedition = $totalColis > 0
            ? round(($colisExpedies / $totalColis) * 100, 1)
            : 0;

        $kpiAvances = [
            'poids_mois_kg' => $poidsMois,
            'taux_expedition' => $tauxExpedition,
        ];

        return view('dashboard', compact(
            'enStock',
            'enExpedition',
            'livresMois',
            'alertes',
            'derniersColis',
            'colisFragilesEnRetard',
            'colisEnSouffrance',
            'tauxOccupation',
            'poidsTotal',
            'colisFragiles',
            'tauxRetours',
            'statsStatuts',
            'evolutionHebdo',
            'kpiAvances',
            'tendanceEnStock',
            'tendanceLivres',
            'tendanceExpedition'
        ));
    }

    /**
     * Dashboard pour les administrateurs.
     */
    protected function adminDashboard(): View
    {
        $anomalies = Colis::where('statut', 'retour')
            ->orWhere(function ($q) {
                $q->whereNotNull('date_expedition')
                    ->where('date_expedition', '<', now()->startOfDay())
                    ->where('statut', '!=', 'livré');
            })
            ->count();

        $kpis = [
            'utilisateurs' => User::count(),
            'colis' => Colis::count(),
            'anomalies' => $anomalies,
        ];

        $auditLogs = HistoriqueMouvement::with(['user', 'colis'])
            ->orderByDesc('date_mouvement')
            ->take(10)
            ->get();

        $activityFeed = HistoriqueMouvement::with(['user', 'colis'])
            ->orderByDesc('date_mouvement')
            ->take(15)
            ->get()
            ->map(function ($m) {
                $m->type = $this->detectMovementType($m);
                return $m;
            });

        $topMagasiniers = HistoriqueMouvement::with('user')
            ->select('user_id', DB::raw('count(*) as total_mouvements'))
            ->whereDate('date_mouvement', Carbon::today())
            ->whereNotNull('user_id')
            ->groupBy('user_id')
            ->orderByDesc('total_mouvements')
            ->take(5)
            ->get();

        try {
            $databaseStatus = DB::connection()->getPdo() ? 'Connectée' : 'Erreur';
        } catch (\Throwable $e) {
            $databaseStatus = 'Erreur';
        }
        $systemStatus = [
            'database' => $databaseStatus,
            'ai_mistral' => 'En ligne (Port 11434)',
            'php_version' => phpversion(),
            'laravel_version' => app()->version(),
        ];

        return view('admin.dashboard', compact('kpis', 'auditLogs', 'activityFeed', 'topMagasiniers', 'systemStatus'));
    }

    /**
     * Détecte le type d'un mouvement pour le flux d'activité.
     */
    protected function detectMovementType(HistoriqueMouvement $m): string
    {
        $nouveau = $m->nouveau_statut;
        $ancien = $m->ancien_statut;

        if ($ancien === null) {
            return 'creation';
        }
        if (in_array($nouveau, ['anomalie', 'retour'], true)) {
            return 'anomalie';
        }
        if (in_array($nouveau, ['reçu', 'en_stock'], true)) {
            return 'scan_entree';
        }
        if (in_array($nouveau, ['en_expédition', 'livré'], true)) {
            return 'scan_sortie';
        }
        return 'modification';
    }

    /**
     * Retourne le HTML du flux d'activité (pour rafraîchissement AJAX).
     */
    public function activityFeed(Request $request): \Illuminate\Contracts\View\View
    {
        $activityFeed = HistoriqueMouvement::with(['user', 'colis'])
            ->orderByDesc('date_mouvement')
            ->take(15)
            ->get()
            ->map(function ($m) {
                $m->type = $this->detectMovementType($m);
                return $m;
            });

        return view('admin.partials.activity-feed', compact('activityFeed'));
    }
}

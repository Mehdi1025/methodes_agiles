<?php

namespace App\Http\Controllers;

use App\Models\Colis;
use App\Models\Emplacement;
use App\Models\HistoriqueMouvement;
use App\Models\User;
use Carbon\Carbon;
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
     * Affiche le tableau de bord selon le rôle (Admin ou Logistique).
     */
    public function __invoke(): View
    {
        if (auth()->user()->role === 'admin') {
            return $this->adminDashboard();
        }

        return $this->logistiqueDashboard();
    }

    /**
     * Dashboard pour les magasiniers (rôle logistique).
     */
    protected function logistiqueDashboard(): View
    {
        $enStock = Colis::where('statut', 'en_stock')->count();
        $enExpedition = Colis::where('statut', 'en_expédition')->count();
        $livresMois = Colis::where('statut', 'livré')
            ->whereMonth('date_expedition', now()->month)
            ->whereYear('date_expedition', now()->year)
            ->count();

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

        $totalEmplacements = Emplacement::count();
        $emplacementsOccupes = Emplacement::where('occupe', true)->count();
        $tauxOccupation = $totalEmplacements > 0
            ? (int) round(($emplacementsOccupes / $totalEmplacements) * 100)
            : 0;

        $poidsTotal = (float) Colis::where('statut', 'en_stock')->sum('poids_kg');
        $colisFragiles = Colis::where('statut', 'en_stock')->where('fragile', true)->count();
        $tauxRetours = Colis::where('statut', 'retour')->count();

        return view('dashboard', compact(
            'enStock',
            'enExpedition',
            'livresMois',
            'alertes',
            'derniersColis',
            'colisFragilesEnRetard',
            'tauxOccupation',
            'poidsTotal',
            'colisFragiles',
            'tauxRetours'
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

        return view('admin.dashboard', compact('kpis', 'auditLogs', 'topMagasiniers', 'systemStatus'));
    }
}

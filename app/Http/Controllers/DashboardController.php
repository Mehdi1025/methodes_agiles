<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Colis;
use App\Models\Emplacement;
use App\Models\HistoriqueMouvement;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
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
        $totalUtilisateurs = User::count();
        $totalClients = Client::count();
        $totalColisSysteme = Colis::count();
        $derniersMouvements = HistoriqueMouvement::with(['user', 'colis'])
            ->orderByDesc('date_mouvement')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalUtilisateurs',
            'totalClients',
            'totalColisSysteme',
            'derniersMouvements'
        ));
    }
}

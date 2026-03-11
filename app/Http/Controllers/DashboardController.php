<?php

namespace App\Http\Controllers;

use App\Models\Colis;
use App\Models\Emplacement;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Affiche le tableau de bord - Centre de commandement logistique.
     */
    public function __invoke(): View
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

        // Nouvelles variables analytiques
        $totalEmplacements = Emplacement::count();
        $emplacementsOccupes = Emplacement::where('occupe', true)->count();
        $tauxOccupation = $totalEmplacements > 0
            ? (int) round(($emplacementsOccupes / $totalEmplacements) * 100)
            : 0;

        $poidsTotal = (float) Colis::where('statut', 'en_stock')->sum('poids_kg');

        $colisFragiles = Colis::where('statut', 'en_stock')->where('fragile', true)->count();

        $tauxRetours = Colis::where('statut', 'retour')->count();

        return view('dashboard', [
            'enStock' => $enStock,
            'enExpedition' => $enExpedition,
            'livresMois' => $livresMois,
            'alertes' => $alertes,
            'derniersColis' => $derniersColis,
            'colisFragilesEnRetard' => $colisFragilesEnRetard,
            'tauxOccupation' => $tauxOccupation,
            'poidsTotal' => $poidsTotal,
            'colisFragiles' => $colisFragiles,
            'tauxRetours' => $tauxRetours,
        ]);
    }
}

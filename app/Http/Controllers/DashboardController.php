<?php

namespace App\Http\Controllers;

use App\Models\Colis;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Affiche le tableau de bord avec les statistiques et derniers colis.
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

        return view('dashboard', [
            'enStock' => $enStock,
            'enExpedition' => $enExpedition,
            'livresMois' => $livresMois,
            'alertes' => $alertes,
            'derniersColis' => $derniersColis,
            'colisFragilesEnRetard' => $colisFragilesEnRetard,
        ]);
    }
}

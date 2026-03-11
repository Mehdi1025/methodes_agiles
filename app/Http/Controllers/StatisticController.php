<?php

namespace App\Http\Controllers;

use App\Models\Colis;
use App\Models\Emplacement;
use App\Models\Transporteur;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class StatisticController extends Controller
{
    /**
     * Affiche le centre d'analyse logistique.
     */
    public function index(): View
    {
        // Volume mensuel : colis reçus ce mois-ci
        $volumeMensuel = Colis::whereMonth('date_reception', now()->month)
            ->whereYear('date_reception', now()->year)
            ->count();

        // Délai moyen d'expédition : moyenne en jours entre réception et expédition
        $colisAvecDates = Colis::whereNotNull('date_reception')
            ->whereNotNull('date_expedition')
            ->get();

        $delaiMoyenExpedition = 0;
        if ($colisAvecDates->isNotEmpty()) {
            $totalJours = $colisAvecDates->sum(fn ($c) => $c->date_reception->diffInDays($c->date_expedition));
            $delaiMoyenExpedition = (int) round($totalJours / $colisAvecDates->count());
        }

        // Taux de livraison à temps : colis livrés sans retard / total livrés
        $totalLivres = Colis::where('statut', 'livré')->whereNotNull('date_expedition')->whereNotNull('date_reception')->count();
        $livresATemps = Colis::where('statut', 'livré')
            ->whereNotNull('date_expedition')
            ->whereNotNull('date_reception')
            ->get()
            ->filter(fn ($c) => $c->date_reception->diffInDays($c->date_expedition) <= 7)
            ->count();

        $tauxLivraisonTemps = $totalLivres > 0
            ? (int) round(($livresATemps / $totalLivres) * 100)
            : 100;

        // Répartition par statut
        $repartitionStatuts = Colis::select('statut', DB::raw('count(*) as total'))
            ->groupBy('statut')
            ->orderByDesc('total')
            ->get();

        $totalColis = Colis::count();
        $repartitionStatuts = $repartitionStatuts->map(function ($item) use ($totalColis) {
            $item->pourcentage = $totalColis > 0 ? round(($item->total / $totalColis) * 100) : 0;
            return $item;
        });

        // Répartition par transporteur
        $repartitionTransporteurs = Transporteur::withCount('colis')
            ->having('colis_count', '>', 0)
            ->orderByDesc('colis_count')
            ->get();

        // Occupation par zone
        $occupationParZone = Emplacement::select('zone', DB::raw('count(*) as total'), DB::raw('sum(occupe) as occupes'))
            ->groupBy('zone')
            ->orderBy('zone')
            ->get()
            ->map(function ($item) {
                $occupes = (int) $item->occupes;
                $total = (int) $item->total;
                $item->taux = $total > 0 ? (int) round(($occupes / $total) * 100) : 0;
                return $item;
            });

        return view('statistics.index', [
            'volumeMensuel' => $volumeMensuel,
            'delaiMoyenExpedition' => $delaiMoyenExpedition,
            'tauxLivraisonTemps' => $tauxLivraisonTemps,
            'repartitionStatuts' => $repartitionStatuts,
            'repartitionTransporteurs' => $repartitionTransporteurs,
            'occupationParZone' => $occupationParZone,
        ]);
    }
}

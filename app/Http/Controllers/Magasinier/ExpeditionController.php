<?php

namespace App\Http\Controllers\Magasinier;

use App\Http\Controllers\Controller;
use App\Models\HistoriqueMouvement;
use App\Models\Transporteur;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ExpeditionController extends Controller
{
    /**
     * Affiche la page Quais d'Expédition avec les transporteurs actifs
     * et leurs colis prêts à partir (en_stock ou reçu).
     */
    public function index(): View
    {
        $transporteurs = Transporteur::where('is_active', true)
            ->with(['colis' => function ($query) {
                $query->whereIn('statut', ['en_stock', 'reçu']);
            }])
            ->get();

        return view('magasinier.expeditions.index', compact('transporteurs'));
    }

    /**
     * Valide le départ des colis pour un transporteur donné.
     * Passe tous les colis prêts en statut 'en_expédition'.
     */
    public function dispatch(Request $request, string $transporteur): RedirectResponse
    {
        $transporteur = Transporteur::where('is_active', true)->findOrFail($transporteur);

        $colis = $transporteur->colis()
            ->whereIn('statut', ['en_stock', 'reçu'])
            ->get();

        $count = $colis->count();

        if ($count === 0) {
            return redirect()
                ->route('magasinier.expeditions.index')
                ->with('warning', "Aucun colis à expédier pour {$transporteur->nom}.");
        }

        $colisList = $transporteur->colis()
            ->whereIn('statut', ['en_stock', 'reçu'])
            ->get();

        foreach ($colisList as $colis) {
            HistoriqueMouvement::create([
                'colis_id' => $colis->id,
                'user_id' => auth()->id(),
                'ancien_statut' => $colis->statut,
                'nouveau_statut' => 'en_expédition',
                'date_mouvement' => now(),
                'commentaire' => 'Expédition validée - colis en transit',
            ]);
        }

        $transporteur->colis()
            ->whereIn('statut', ['en_stock', 'reçu'])
            ->update([
                'statut' => 'en_expédition',
                'date_expedition' => now(),
            ]);

        return redirect()
            ->route('magasinier.expeditions.index')
            ->with('success', "{$count} colis expédiés avec succès pour {$transporteur->nom}.");
    }
}

<?php

namespace App\Http\Controllers\Magasinier;

use App\Http\Controllers\Controller;
use App\Models\Colis;
use App\Models\HistoriqueMouvement;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PickingController extends Controller
{
    /**
     * Affiche la page Pick & Pack (Missions de picking du jour).
     */
    public function index(): View
    {
        $colisAPreparer = Colis::where('statut', 'en_stock')
            ->with('emplacement')
            ->get();

        return view('magasinier.picking.index', compact('colisAPreparer'));
    }

    /**
     * Marque un colis comme "en préparation" (pick).
     */
    public function pick(Request $request, Colis $colis): JsonResponse
    {
        if ($colis->statut !== 'en_stock') {
            return response()->json([
                'success' => false,
                'message' => 'Ce colis n\'est plus en stock.',
            ], 422);
        }

        $colis->update(['statut' => 'en_preparation']);
        HistoriqueMouvement::create([
            'colis_id' => $colis->id,
            'user_id' => auth()->id(),
            'ancien_statut' => 'en_stock',
            'nouveau_statut' => 'en_preparation',
            'date_mouvement' => now(),
            'commentaire' => 'Pick - colis mis en préparation',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Colis préparé !',
        ]);
    }

    /**
     * Signale une anomalie sur un colis.
     */
    public function reportAnomaly(Request $request, Colis $colis): JsonResponse
    {
        $validated = $request->validate([
            'raison' => ['required', 'string', 'max:500'],
        ]);

        $ancienStatut = $colis->statut;
        $colis->update(['statut' => 'anomalie']);
        HistoriqueMouvement::create([
            'colis_id' => $colis->id,
            'user_id' => auth()->id(),
            'ancien_statut' => $ancienStatut,
            'nouveau_statut' => 'anomalie',
            'date_mouvement' => now(),
            'commentaire' => 'Anomalie signalée : ' . $validated['raison'],
        ]);

        $reference = $colis->code_qr ?? '#' . substr($colis->id, 0, 8);

        return response()->json([
            'success' => true,
            'ai_message' => "🤖 LogisBot : Anomalie enregistrée pour le colis {$reference} ({$validated['raison']}). J'ai notifié l'Administrateur sur son tableau de bord.",
        ]);
    }
}

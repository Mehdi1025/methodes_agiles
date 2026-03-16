<?php

namespace App\Http\Controllers\Magasinier;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Colis;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReceptionController extends Controller
{
    /**
     * Affiche le terminal Smart Scanner de réception.
     */
    public function index(): View
    {
        return view('magasinier.colis.scanner');
    }

    /**
     * Traite un scan (référence code-barres) et crée ou met à jour le colis.
     */
    public function scan(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'reference' => ['required', 'string', 'max:255'],
        ]);

        $reference = trim($validated['reference']);

        $colis = Colis::where('code_qr', $reference)->first();

        if ($colis) {
            $colis->update(['statut' => 'en_stock']);
        } else {
            $defaultClient = Client::first();
            if (! $defaultClient) {
                return response()->json([
                    'success' => false,
                    'message' => 'Aucun client en base. Créez au moins un client pour réceptionner des colis.',
                ], 422);
            }

            $colis = Colis::create([
                'code_qr' => $reference,
                'description' => 'Colis réceptionné par scan - ' . $reference,
                'poids_kg' => 0,
                'dimensions' => 'À définir',
                'statut' => 'en_stock',
                'date_reception' => now(),
                'client_id' => $defaultClient->id,
            ]);
        }

        return response()->json([
            'success' => true,
            'colis' => [
                'id' => $colis->id,
                'reference' => $colis->code_qr ?? $reference,
            ],
            'message' => 'Colis ' . ($colis->code_qr ?? $reference) . ' réceptionné avec succès.',
        ]);
    }
}

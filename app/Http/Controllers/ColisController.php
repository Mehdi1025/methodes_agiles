<?php
// d:\projet_methode_agile2\app\Http\Controllers\ColisController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\Colis;
use App\Models\Client;
use App\Models\HistoriqueMouvement;
use App\Models\Transporteur;
use App\Models\Emplacement;

class ColisController extends Controller
{
    public function index(Request $request)
    {
        $query = Colis::with('client')->latest();

        if ($search = $request->query('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('code_qr', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%')
                    ->orWhereHas('client', fn ($c) => $c->where('nom', 'like', '%' . $search . '%')->orWhere('prenom', 'like', '%' . $search . '%'));
            });
        }

        $colis = $query->paginate(10)->withQueryString();

        $totalColis = Colis::count();
        $colisFragiles = Colis::where('fragile', true)->count();
        $expediesAujourdhui = Colis::whereDate('date_expedition', now()->toDateString())->count();
        $enAttente = Colis::whereIn('statut', ['reçu', 'en_stock', 'en_preparation'])->count();
        $topClients = Client::withCount('colis')->having('colis_count', '>', 0)->orderByDesc('colis_count')->limit(5)->get();

        return view('colis.index', compact('colis', 'totalColis', 'colisFragiles', 'expediesAujourdhui', 'enAttente', 'topClients'));
    }

    public function show($id)
    {
        $colis = Colis::with('client')->findOrFail($id);
        return view('colis.show', ['colis' => $colis]);
    }

    /**
     * Redirige vers show si le code existe, sinon vers create avec le code pré-rempli.
     */
    public function lookup(Request $request)
    {
        $code = $request->query('code_qr');
        if (empty($code)) {
            return redirect()->route('colis.create');
        }

        $colis = Colis::where('code_qr', $code)->orWhere('id', $code)->first();
        if ($colis) {
            session(['last_scanned_colis_id' => $colis->id]);
            return redirect()->route('colis.show', $colis->id);
        }

        return redirect()->to(route('colis.create') . '?code_qr=' . urlencode($code));
    }

    public function create()
    {
        $clients = Client::orderBy('nom')->get();
        $transporteurs = Transporteur::orderBy('nom')->get(); // Fetch transporters
        $emplacements = Emplacement::orderBy('zone')->get(); // Fetch locations
        return view('colis.create', compact('clients', 'transporteurs', 'emplacements'));
    }

    public function store(Request $request)
    {
        Log::info('Colis store - données reçues', $request->all());

        // Auto-génération du code_qr si vide
        $codeQr = $request->filled('code_qr') ? $request->code_qr : null;
        if (empty($codeQr)) {
            $codeQr = 'COL-' . now()->format('YmdHis') . '-' . strtoupper(Str::random(6));
        }
        $request->merge([
            'code_qr' => $codeQr,
            'transporteur_id' => $request->filled('transporteur_id') ? $request->transporteur_id : null,
            'emplacement_id' => $request->filled('emplacement_id') ? $request->emplacement_id : null,
        ]);

        $validated = $request->validate([
            'code_qr' => 'nullable|string|max:50|unique:colis,code_qr',
            'client_id' => 'required|exists:clients,id',
            'statut' => 'required|string|max:255',
            'date_reception' => 'required|date',
            'description' => 'nullable|string|max:65535',
            'poids_kg' => 'nullable|numeric|min:0',
            'dimensions' => 'nullable|string|max:255',
            'fragile' => 'nullable|boolean',
            'date_expedition' => 'nullable|date',
            'transporteur_id' => 'nullable|exists:transporteurs,id',
            'emplacement_id' => 'nullable|exists:emplacements,id',
        ]);

        try {
            $colis = Colis::create([
                'code_qr' => $validated['code_qr'] ?: null,
                'client_id' => $validated['client_id'],
                'statut' => $validated['statut'],
                'date_reception' => $validated['date_reception'],
                'description' => $validated['description'] ?? '',
                'poids_kg' => $validated['poids_kg'] ?? 0,
                'dimensions' => $validated['dimensions'] ?? '',
                'fragile' => (bool) ($validated['fragile'] ?? false),
                'date_expedition' => $validated['date_expedition'] ?? null,
                'transporteur_id' => $validated['transporteur_id'] ?: null,
                'emplacement_id' => $validated['emplacement_id'] ?: null,
            ]);
            HistoriqueMouvement::create([
                'colis_id' => $colis->id,
                'user_id' => auth()->id(),
                'ancien_statut' => null,
                'nouveau_statut' => $colis->statut,
                'date_mouvement' => now(),
                'commentaire' => 'Création manuelle du colis',
            ]);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }

        return redirect()->route('colis.index');
    }

    public function edit($id)
    {
        $colis = Colis::findOrFail($id);
        $clients = Client::orderBy('nom')->get();
        $transporteurs = Transporteur::orderBy('nom')->get(); // Récupération des transporteurs
        $emplacements = Emplacement::orderBy('zone')->get(); // Récupération des emplacements
        return view('colis.edit', compact('colis', 'clients', 'transporteurs', 'emplacements'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'statut' => 'required|string|max:255',
            'date_reception' => 'required|date',
            'description' => 'nullable|string|max:65535',
            'poids_kg' => 'nullable|numeric|min:0',
            'dimensions' => 'nullable|string|max:255',
            'fragile' => 'nullable|boolean',
            'date_expedition' => 'nullable|date',
            'transporteur_id' => 'nullable|exists:transporteurs,id',
            'emplacement_id' => 'nullable|exists:emplacements,id',
        ]);

        // Valeurs par défaut pour colonnes NOT NULL (poids_kg, dimensions)
        $validated['poids_kg'] = $validated['poids_kg'] ?? 0;
        $validated['dimensions'] = $validated['dimensions'] ?? '';
        $validated['description'] = $validated['description'] ?? '';

        $colis = Colis::findOrFail($id);
        $ancienStatut = $colis->statut;
        $colis->update($validated);

        if ($ancienStatut !== $validated['statut']) {
            HistoriqueMouvement::create([
                'colis_id' => $colis->id,
                'user_id' => auth()->id(),
                'ancien_statut' => $ancienStatut,
                'nouveau_statut' => $validated['statut'],
                'date_mouvement' => now(),
                'commentaire' => 'Modification du statut via l\'interface colis',
            ]);
        }

        return redirect()->route('colis.show', $colis->id)->with('success', 'Colis mis à jour avec succès.');
    }

    public function destroy($id)
    {
        $colis = Colis::findOrFail($id);
        $colis->delete();

        return redirect()->route('colis.index')->with('success', 'Colis supprimé avec succès.');
    }
}
<?php
// d:\projet_methode_agile2\app\Http\Controllers\ColisController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Colis;
use App\Models\Client;
use App\Models\Transporteur; // Ajout du modèle Transporteur
use App\Models\Emplacement; // Ajout du modèle Emplacement

class ColisController extends Controller
{
    public function index()
    {
        $colis = Colis::with('client')->orderBy('created_at', 'desc')->get();
        return view('colis.index', compact('colis'));
    }

    public function show($id)
    {
        $colis = Colis::with('client')->findOrFail($id);
        return view('colis.show', ['colis' => $colis]);
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
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'statut' => 'required|string|max:255',
            'date_reception' => 'required|date',
            'description' => 'nullable|string', // Description n'est plus obligatoire
            'poids_kg' => 'nullable|numeric',
            'dimensions' => 'nullable|string',
            'fragile' => 'nullable|boolean',
            'date_expedition' => 'nullable|date',
            'transporteur_id' => 'nullable|exists:transporteurs,id',
            'emplacement_id' => 'nullable|exists:emplacements,id',
        ]);

        $colis = new Colis();
        $colis->client_id = $validated['client_id'];
        $colis->statut = $validated['statut'];
        $colis->date_reception = $validated['date_reception'];
        $colis->description = $request->input('description', ''); // Valeur par défaut vide
        $colis->poids_kg = $request->input('poids_kg', 0);
        $colis->dimensions = $request->input('dimensions', '');
        $colis->fragile = $request->input('fragile', false);
        $colis->save();

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
            'description' => 'nullable|string',
            'poids_kg' => 'nullable|numeric',
            'dimensions' => 'nullable|string',
            'fragile' => 'nullable|boolean',
            'date_expedition' => 'nullable|date',
            'transporteur_id' => 'nullable|exists:transporteurs,id',
            'emplacement_id' => 'nullable|exists:emplacements,id',
        ]);

        $colis = Colis::findOrFail($id);
        $colis->update($validated);

        return redirect()->route('colis.show', $colis->id)->with('success', 'Colis mis à jour avec succès.');
    }

    public function destroy($id)
    {
        $colis = Colis::findOrFail($id);
        $colis->delete();

        return redirect()->route('colis.index')->with('success', 'Colis supprimé avec succès.');
    }
}
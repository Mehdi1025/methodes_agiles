<?php
// d:\projet_methode_agile2\app\Http\Controllers\ColisController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Colis;
use App\Models\Client;

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
        return view('colis.create', compact('clients'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'statut' => 'required|string|max:255',
            'date_reception' => 'required|date',
        ]);
        $colis = new Colis();
        $colis->client_id = $validated['client_id'];
        $colis->statut = $validated['statut'];
        $colis->date_reception = $validated['date_reception'];
        $colis->description = $request->input('description', '');
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
        return view('colis.edit', compact('colis', 'clients'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'statut' => 'required|string|max:255',
            'date_reception' => 'required|date',
        ]);
        $colis = Colis::findOrFail($id);
        $colis->client_id = $validated['client_id'];
        $colis->statut = $validated['statut'];
        $colis->date_reception = $validated['date_reception'];
        $colis->description = $request->input('description', $colis->description);
        $colis->poids_kg = $request->input('poids_kg', $colis->poids_kg);
        $colis->dimensions = $request->input('dimensions', $colis->dimensions);
        $colis->fragile = $request->input('fragile', $colis->fragile);
        $colis->save();
        return redirect()->route('colis.index');
    }

    public function destroy($id)
    {
        $colis = Colis::findOrFail($id);
        $colis->delete();
        return redirect()->route('colis.index');
    }
}
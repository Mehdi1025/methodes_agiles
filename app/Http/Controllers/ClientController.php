<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Liste des clients (annuaire) avec recherche et pagination.
     */
    public function index(Request $request)
    {
        $query = Client::withCount('colis')->latest();

        if ($search = $request->query('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('nom', 'like', '%' . $search . '%')
                    ->orWhere('prenom', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('telephone', 'like', '%' . $search . '%');
            });
        }

        $clients = $query->paginate(10)->withQueryString();

        return view('clients.index', compact('clients'));
    }

    /**
     * Formulaire de création d'un client.
     */
    public function create()
    {
        return view('clients.create');
    }

    /**
     * Enregistre un nouveau client.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:100',
            'prenom' => 'required|string|max:100',
            'email' => 'required|email|unique:clients,email',
            'telephone' => 'required|string|max:20',
            'adresse_livraison' => 'required|string',
        ]);

        $client = Client::create($validated);

        return redirect()->route('clients.show', $client)->with('success', 'Client créé avec succès.');
    }

    /**
     * Formulaire d'édition d'un client.
     */
    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    /**
     * Met à jour un client.
     */
    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:100',
            'prenom' => 'required|string|max:100',
            'email' => 'required|email|unique:clients,email,' . $client->id,
            'telephone' => 'required|string|max:20',
            'adresse_livraison' => 'required|string',
        ]);

        $client->update($validated);

        return redirect()->route('clients.show', $client)->with('success', 'Client mis à jour avec succès.');
    }

    /**
     * Affiche la fiche profil client 360° avec ses colis et statistiques.
     */
    public function show(Client $client)
    {
        $client->load(['colis' => fn ($q) => $q->latest('created_at')]);

        $totalColis = $client->colis->count();
        $colisLivres = $client->colis->where('statut', 'livré')->count();
        $colisEnCours = $client->colis->whereIn('statut', ['en_preparation', 'en_expédition'])->count();

        return view('clients.show', compact('client', 'totalColis', 'colisLivres', 'colisEnCours'));
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transporteur;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminParametreController extends Controller
{
    /**
     * Affiche la page des paramètres système (référentiels).
     */
    public function index(): View
    {
        $transporteurs = Transporteur::latest()->get();

        return view('admin.parametres.index', compact('transporteurs'));
    }

    /**
     * Crée un nouveau transporteur.
     *
     * TODO: Prochaine étape — Modifier le ColisController pour utiliser
     * Transporteur::where('is_active', true)->get() dans le formulaire de création
     * des colis par les magasiniers.
     */
    public function storeTransporteur(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nom' => ['required', 'string', 'max:100', 'unique:transporteurs,nom'],
            'telephone' => ['nullable', 'string', 'max:50'],
        ], [
            'nom.required' => 'Le nom du transporteur est obligatoire.',
            'nom.unique' => 'Ce transporteur existe déjà.',
        ]);

        Transporteur::create([
            'nom' => $validated['nom'],
            'telephone' => $validated['telephone'] ?? null,
            'contact' => $validated['telephone'] ?? '',
            'delai_moyen_jours' => 3,
            'is_active' => true,
        ]);

        return redirect()->route('admin.parametres.index')->with('success', "Le transporteur {$validated['nom']} a été ajouté.");
    }

    /**
     * Supprime un transporteur.
     */
    public function destroyTransporteur(string $id): RedirectResponse
    {
        $transporteur = Transporteur::findOrFail($id);
        $nom = $transporteur->nom;
        $transporteur->delete();

        return redirect()->route('admin.parametres.index')->with('success', "Le transporteur {$nom} a été supprimé.");
    }
}

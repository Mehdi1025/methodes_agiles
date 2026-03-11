<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AdminUserController extends Controller
{
    /**
     * Redirige vers la page Gestion Équipe.
     */
    public function index(): RedirectResponse
    {
        return redirect()->route('admin.equipe.index');
    }

    /**
     * Affiche le formulaire de création d'un employé.
     */
    public function create(): View
    {
        return view('admin.users.create');
    }

    /**
     * Crée un nouvel utilisateur (employé).
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'in:admin,logistique'],
        ], [
            'name.required' => 'Le nom est obligatoire.',
            'email.required' => "L'email est obligatoire.",
            'email.unique' => "Cet email est déjà utilisé.",
            'password.required' => 'Le mot de passe est obligatoire.',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
            'role.required' => 'Le rôle est obligatoire.',
            'role.in' => 'Le rôle doit être Admin ou Logistique.',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        return redirect()->route('admin.equipe.index')->with('success', "L'employé {$validated['name']} a été créé avec succès.");
    }

    /**
     * Supprime un utilisateur (empêche l'admin de se supprimer lui-même).
     */
    public function destroy(User $user): RedirectResponse
    {
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        $name = $user->name;
        $user->delete();

        return redirect()->back()->with('success', "L'employé {$name} a été supprimé.");
    }
}

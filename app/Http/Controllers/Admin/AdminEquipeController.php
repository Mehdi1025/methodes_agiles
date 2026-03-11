<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\View\View;

class AdminEquipeController extends Controller
{
    /**
     * Affiche la page Gestion Équipe (liste des employés).
     */
    public function index(): View
    {
        $utilisateurs = User::latest()->paginate(10);

        return view('admin.equipe.index', compact('utilisateurs'));
    }
}

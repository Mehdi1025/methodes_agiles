<?php

namespace App\Http\Controllers;

use App\Models\Colis;

class ColisController extends Controller
{
    public function index()
    {
        $colis = Colis::all(); // Récupérer tous les colis
        return view('dashboard_colis', compact('colis'));
    }
}

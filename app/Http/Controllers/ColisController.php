<?php
// d:\projet_methode_agile2\app\Http\Controllers\ColisController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ColisController extends Controller
{
    public function index()
    {
        // Exemple de données fictives pour les colis
        $colis = [
            ['id' => 'COL-58884852', 'client' => 'Agathe Leveque', 'statut' => 'reçu', 'date' => '11/03/2026'],
            ['id' => 'COL-9928310', 'client' => 'Emmanuel Chauvet', 'statut' => 'livré', 'date' => '11/03/2026'],
            ['id' => 'COL-67028712', 'client' => 'Laurence Maury', 'statut' => 'reçu', 'date' => '10/03/2026'],
            ['id' => 'COL-20832628', 'client' => 'Sébastien Roux', 'statut' => 'en expédition', 'date' => '10/03/2026'],
        ];

        return view('colis.index', compact('colis'));
    }
}
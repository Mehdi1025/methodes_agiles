<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Emplacement;
use Illuminate\View\View;

class AdminLocationController extends Controller
{
    /**
     * Affiche la cartographie interactive de l'entrepôt.
     */
    public function index(): View
    {
        $emplacements = Emplacement::with('colis')
            ->orderBy('zone')
            ->orderBy('allee')
            ->get()
            ->groupBy('zone');

        $total = Emplacement::count();
        $occupes = Emplacement::whereHas('colis')->count();
        $libres = $total - $occupes;

        return view('admin.emplacements.index', compact('emplacements', 'total', 'occupes', 'libres'));
    }
}

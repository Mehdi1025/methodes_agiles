<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ModeController extends Controller
{
    /**
     * Bascule entre Mode Avancé et Mode Terrain (Simple).
     */
    public function switch(Request $request): RedirectResponse
    {
        $mode = $request->query('mode', 'advanced');

        session(['mode' => $mode === 'simple' ? 'simple' : 'advanced']);

        return redirect()->route('dashboard');
    }
}

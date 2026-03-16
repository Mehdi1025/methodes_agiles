<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ColisController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AssistantController;
use App\Http\Controllers\StatisticController;
use App\Http\Controllers\Magasinier\ReceptionController;
use App\Http\Controllers\Magasinier\ExpeditionController;
use App\Http\Controllers\Magasinier\PickingController;
use App\Http\Controllers\Admin\AdminEquipeController;
use App\Http\Controllers\Admin\AdminLocationController;
use App\Http\Controllers\Admin\AdminParametreController;
use App\Http\Controllers\Admin\AdminUserController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

Route::get('/dashboard', DashboardController::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    
    // --- ROUTES SPÉCIFIQUES (À mettre AVANT les ressources) ---
    Route::get('/colis/scanner', [ReceptionController::class, 'index'])->name('magasinier.colis.scanner');
    Route::post('/colis/scan', [ReceptionController::class, 'scan'])->name('magasinier.colis.scan');
    
    // --- RESSOURCES ---
    Route::resource('colis', ColisController::class);

    // --- MAGASINIER / LOGISTIQUE ---
    Route::get('/expeditions', [ExpeditionController::class, 'index'])->name('magasinier.expeditions.index');
    Route::post('/expeditions/{transporteur}/dispatch', [ExpeditionController::class, 'dispatch'])->name('magasinier.expeditions.dispatch');
    Route::get('/picking', [PickingController::class, 'index'])->name('magasinier.picking.index');
    Route::post('/picking/{colis}/pick', [PickingController::class, 'pick'])->name('magasinier.picking.pick');
    Route::post('/picking/{colis}/anomalie', [PickingController::class, 'reportAnomaly'])->name('magasinier.picking.anomalie');
    
    // --- AUTRES VUES ---
    Route::get('/scanner', fn () => view('scanner.index'))->name('scanner.index');
    Route::get('/clients', fn () => view('clients.index'))->name('clients.index');
    Route::get('/transporteurs', fn () => view('transporteurs.index'))->name('transporteurs.index');
    
    // --- IA & STATS ---
    Route::get('/assistant', [AssistantController::class, 'index'])->name('assistant.index');
    Route::post('/assistant/chat', [AssistantController::class, 'chat'])->name('assistant.chat');
    Route::get('/statistiques', [StatisticController::class, 'index'])->name('statistiques.index');
    Route::get('/statistiques/export-csv', [StatisticController::class, 'exportCsv'])->name('statistiques.export-csv');
});

// Routes Admin (protégées par rôle admin)
Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/equipe', [AdminEquipeController::class, 'index'])->name('equipe.index');
    Route::get('/emplacements', [AdminLocationController::class, 'index'])->name('emplacements.index');
    Route::get('/parametres', [AdminParametreController::class, 'index'])->name('parametres.index');
    Route::post('/parametres/transporteurs', [AdminParametreController::class, 'storeTransporteur'])->name('transporteurs.store');
    Route::delete('/parametres/transporteurs/{id}', [AdminParametreController::class, 'destroyTransporteur'])->name('transporteurs.destroy');
    Route::post('/system/clear-cache', [DashboardController::class, 'clearCache'])->name('clear-cache');
    Route::resource('users', AdminUserController::class)->except(['show']);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

Route::get('/dashboard', \App\Http\Controllers\DashboardController::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/colis', fn () => view('colis.index'))->name('colis.index');
    Route::get('/colis/scanner', [\App\Http\Controllers\Magasinier\ReceptionController::class, 'index'])->name('magasinier.colis.scanner');
    Route::post('/colis/scan', [\App\Http\Controllers\Magasinier\ReceptionController::class, 'scan'])->name('magasinier.colis.scan');
    Route::get('/expeditions', [\App\Http\Controllers\Magasinier\ExpeditionController::class, 'index'])->name('magasinier.expeditions.index');
    Route::post('/expeditions/{transporteur}/dispatch', [\App\Http\Controllers\Magasinier\ExpeditionController::class, 'dispatch'])->name('magasinier.expeditions.dispatch');
    Route::get('/picking', [\App\Http\Controllers\Magasinier\PickingController::class, 'index'])->name('magasinier.picking.index');
    Route::post('/picking/{colis}/pick', [\App\Http\Controllers\Magasinier\PickingController::class, 'pick'])->name('magasinier.picking.pick');
    Route::post('/picking/{colis}/anomalie', [\App\Http\Controllers\Magasinier\PickingController::class, 'reportAnomaly'])->name('magasinier.picking.anomalie');
    Route::get('/colis/create', fn () => redirect()->route('colis.index'))->name('colis.create');
    Route::get('/scanner', fn () => view('scanner.index'))->name('scanner.index');
    Route::get('/clients', fn () => view('clients.index'))->name('clients.index');
    Route::get('/transporteurs', fn () => view('transporteurs.index'))->name('transporteurs.index');
    Route::get('/assistant', [\App\Http\Controllers\AssistantController::class, 'index'])->name('assistant.index');
    Route::post('/assistant/chat', [\App\Http\Controllers\AssistantController::class, 'chat'])->name('assistant.chat');
    Route::get('/statistiques', [\App\Http\Controllers\StatisticController::class, 'index'])->name('statistiques.index');
    Route::get('/statistiques/export-csv', [\App\Http\Controllers\StatisticController::class, 'exportCsv'])->name('statistiques.export-csv');

});

// Routes Admin (protégées par rôle admin)
Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/equipe', [\App\Http\Controllers\Admin\AdminEquipeController::class, 'index'])->name('equipe.index');
    Route::get('/emplacements', [\App\Http\Controllers\Admin\AdminLocationController::class, 'index'])->name('emplacements.index');
    Route::get('/parametres', [\App\Http\Controllers\Admin\AdminParametreController::class, 'index'])->name('parametres.index');
    Route::post('/parametres/transporteurs', [\App\Http\Controllers\Admin\AdminParametreController::class, 'storeTransporteur'])->name('transporteurs.store');
    Route::delete('/parametres/transporteurs/{id}', [\App\Http\Controllers\Admin\AdminParametreController::class, 'destroyTransporteur'])->name('transporteurs.destroy');
    Route::post('/system/clear-cache', [\App\Http\Controllers\DashboardController::class, 'clearCache'])->name('clear-cache');
    Route::resource('users', \App\Http\Controllers\Admin\AdminUserController::class)->except(['show']);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

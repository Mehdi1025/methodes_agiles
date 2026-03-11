<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

Route::get('/dashboard', \App\Http\Controllers\DashboardController::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/colis', fn () => view('colis.index'))->name('colis.index');
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
    Route::get('/emplacements', fn () => view('admin.emplacements.index'))->name('emplacements.index');
    Route::get('/parametres', fn () => view('admin.parametres.index'))->name('parametres.index');
    Route::resource('users', \App\Http\Controllers\Admin\AdminUserController::class)->except(['show']);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

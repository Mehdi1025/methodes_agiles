<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ColisController;
use App\Http\Controllers\ModeController;
use App\Http\Controllers\ClientController;
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
use SimpleSoftwareIO\QrCode\Facades\QrCode;

Route::redirect('/', '/login');

Route::get('/dashboard', DashboardController::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/switch-mode', [ModeController::class, 'switch'])
    ->middleware(['auth', 'verified'])
    ->name('mode.switch');

Route::middleware(['auth', 'verified'])->group(function () {
    
    // --- ROUTES SPÉCIFIQUES (À mettre AVANT les ressources) ---
    Route::get('/colis/scanner', [ReceptionController::class, 'index'])->name('magasinier.colis.scanner');
    Route::post('/colis/scan', [ReceptionController::class, 'scan'])->name('magasinier.colis.scan');
    Route::get('/colis/du-jour', [ReceptionController::class, 'colisDuJour'])->name('magasinier.colis.du-jour');
    Route::get('/colis/lookup', [ColisController::class, 'lookup'])->name('colis.lookup');

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
    Route::get('/scanner/test-qr', function () {
        $code = request('code', 'TEST-' . now()->format('YmdHis'));
        $qrSvg = QrCode::format('svg')->size(256)->generate($code);
        return view('scanner.test-qr', ['code' => $code, 'qrSvg' => $qrSvg]);
    })->name('scanner.test-qr');
    Route::get('/clients', [ClientController::class, 'index'])->name('clients.index');
    Route::get('/clients/create', [ClientController::class, 'create'])->name('clients.create');
    Route::post('/clients', [ClientController::class, 'store'])->name('clients.store');
    Route::get('/clients/{client}/edit', [ClientController::class, 'edit'])->name('clients.edit');
    Route::put('/clients/{client}', [ClientController::class, 'update'])->name('clients.update');
    Route::get('/clients/{client}', [ClientController::class, 'show'])->name('clients.show');
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
    Route::get('/dashboard/activity-feed', [DashboardController::class, 'activityFeed'])->name('dashboard.activity-feed');
    Route::resource('users', AdminUserController::class)->except(['show']);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ColisController;

Route::get('/dashboard-colis', [ColisController::class, 'index'])->name('dashboard.colis');

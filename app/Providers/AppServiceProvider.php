<?php

namespace App\Providers;

use App\Models\Colis;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useTailwind();
        Schema::defaultStringLength(191);

        // Partage les compteurs Watchdog pour la sidebar logistique
        View::composer('layouts.app', function ($view) {
            if (auth()->check() && auth()->user()->role !== 'admin') {
                $view->with('colisEnSouffranceTotal', Colis::whereNotIn('statut', ['livré', 'en_expédition', 'anomalie'])
                    ->where('created_at', '<=', now()->subHours(24))
                    ->count());
                $view->with('colisEnSouffranceQuai', Colis::whereNotIn('statut', ['livré', 'en_expédition', 'anomalie'])
                    ->where('created_at', '<=', now()->subHours(24))
                    ->where('statut', 'en_preparation')
                    ->count());
            } else {
                $view->with('colisEnSouffranceTotal', 0);
                $view->with('colisEnSouffranceQuai', 0);
            }
        });
    }
}

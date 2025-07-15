<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Produit;
use App\Observers\ProduitObserver;

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
        Produit::observe(ProduitObserver::class);
    }
}

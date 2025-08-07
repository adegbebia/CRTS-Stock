<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Route;
//use Illuminate\Support\Facades\View;
use App\Models\AlerteProduit;

use Illuminate\Support\ServiceProvider;
use App\Models\Produit;
use App\Observers\ProduitObserver;
use App\Models\Article;
use App\Observers\ArticleObserver;
use Illuminate\Support\Facades\DB;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Déclaration du route model binding personnalisé
        // Route::bind('alerte', function ($value) {
        //     return AlerteProduit::where('alerteProd_id', $value)->firstOrFail();
        // });

        // // Partager globalement les alertes pour la navbar (vue layouts.partials.navbar)
        // View::composer('layouts.partials.navbar', function ($view) {
        //     $alertes = AlerteProduit::with('produit')
        //         ->orderBy('datedeclenchement', 'desc')
        //         ->get();

        //     $view->with('alertes', $alertes);
        // });



        // View::composer('*', function ($view) {
        //     $alertes = AlerteProduit::with('produit')->get();
        //     $view->with('alertes', $alertes);
        // });

        Produit::observe(ProduitObserver::class);
        Article::observe(ArticleObserver::class);

        if (DB::getDriverName() === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = ON;');
         }
    }
}

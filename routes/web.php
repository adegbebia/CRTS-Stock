<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

use App\Http\Controllers\ProduitController;
use App\Http\Controllers\ArticleController;

use App\Http\Controllers\MouvementProduitController;
use App\Http\Controllers\MouvementArticleController;

use App\Http\Controllers\ConsommationProduitController;
use App\Http\Controllers\ConsommationArticleController;

use App\Http\Controllers\AlerteProduitController;
use App\Http\Controllers\AlerteArticleController;


use App\Http\Controllers\RapportProduitController;
use App\Http\Controllers\RapportArticleController;

use App\Http\Controllers\Auth\LoginController;

use App\Http\Controllers\DashboardController;



Route::get('/', function () {
    return view('welcome');
});


Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');



    // Utilisateurs
    Route::resource('users', UserController::class);

    // PRODUITS
    Route::resource('produits', ProduitController::class);
    Route::resource('mouvements-produits', MouvementProduitController::class);
    Route::resource('consommations-produits', ConsommationProduitController::class)
        ->parameters(['consommations-produits' => 'consommations_produit']);


    // ARTICLES (collations)
    Route::resource('articles', ArticleController::class);
    Route::resource('mouvements-articles', MouvementArticleController::class);
    Route::resource('consommations-articles', ConsommationArticleController::class)->parameters([
        'consommations-articles' => 'consommation_article'
    ]);

    // Alertes (valables pour les produits et articles si tu gères tout au même endroit)
    
    Route::resource('alertes-produits', AlerteProduitController::class)->parameters(['alertes-produits' => 'alerte']);

    Route::resource('alertes-articles', AlerteArticleController::class)->parameters(['alertes-articles'=>'alerte']);


    // RAPPORTS PRODUITS
    Route::get('/rapports-produits', [RapportProduitController::class, 'index'])->name('rapports-produits.index');
    Route::post('/rapports-produits/generer', [RapportProduitController::class, 'generer'])->name('rapports-produits.generer');

    // RAPPORTS ARTICLES
    Route::get('/rapports-articles', [RapportArticleController::class, 'index'])->name('rapports-articles.index');
    Route::post('/rapports-articles/generer', [RapportArticleController::class, 'generer'])->name('rapports-articles.generer');

});
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

use App\Http\Controllers\ProduitController;
use App\Http\Controllers\ArticleController;

use App\Http\Controllers\MouvementProduitController;
use App\Http\Controllers\MouvementArticleController;

use App\Http\Controllers\ConsommationProduitController;
use App\Http\Controllers\ConsommationArticleController;

use App\Http\Controllers\AlerteController;

use App\Http\Controllers\RapportProduitController;
use App\Http\Controllers\RapportArticleController;

use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

// Utilisateurs
Route::resource('users', UserController::class);

// PRODUITS
Route::resource('produits', ProduitController::class);
Route::resource('mouvements-produits', MouvementProduitController::class);
Route::resource('consommations-produits', ConsommationProduitController::class);

// ARTICLES (collations)
Route::resource('articles', ArticleController::class);
Route::resource('mouvements-articles', MouvementArticleController::class);
Route::resource('consommations-articles', ConsommationArticleController::class);

// Alertes (valables pour les produits et articles si tu gères tout au même endroit)
Route::resource('alertes', AlerteController::class);

// RAPPORTS PRODUITS
Route::get('/rapports-produits', [RapportProduitController::class, 'index'])->name('rapports-produits.index');
Route::post('/rapports-produits/generer', [RapportProduitController::class, 'generer'])->name('rapports-produits.generer');

// RAPPORTS ARTICLES
Route::get('/rapports-articles', [RapportArticleController::class, 'index'])->name('rapports-articles.index');
Route::post('/rapports-articles/generer', [RapportArticleController::class, 'generer'])->name('rapports-articles.generer');

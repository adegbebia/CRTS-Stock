<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\MouvementController;
use App\Http\Controllers\ConsommationController;
use App\Http\Controllers\AlerteController;






Route::get('/', function () {
    return view('welcome');
});

Route::resource('users', UserController::class);

Route::resource('produits', ProduitController::class);

Route::resource('mouvements', MouvementController::class);

Route::resource('consommations', ConsommationController::class);

Route::resource('alertes', AlerteController::class);

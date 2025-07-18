<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\MouvementController;
use App\Http\Controllers\ConsommationController;
use App\Http\Controllers\AlerteController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RapportController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    Route::resource('users', UserController::class);
    Route::resource('produits', ProduitController::class);
    Route::resource('mouvements', MouvementController::class);
    Route::resource('consommations', ConsommationController::class);
    Route::resource('alertes', AlerteController::class);

    Route::get('/rapports', function () {
        return view('rapports.index');
    })->name('rapports.index');

    Route::post('/rapports/generer', [RapportController::class, 'generer'])->name('rapports.generer');
});

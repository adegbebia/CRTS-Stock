<?php

namespace App\Http\Controllers;

use Illuminate\Support\Collection;
use App\Models\AlerteProduit;
use App\Models\AlerteArticle;
class DashboardController extends Controller
{
    

public function dashboard()
{
    $alertesProduits = AlerteProduit::with('produit')
        ->orderBy('datedeclenchement', 'desc')
        ->get();

    $alertesArticles = AlerteArticle::with('article')
        ->orderBy('datedeclenchement', 'desc')
        ->get();

    return view('dashboard', [
        'alertesProduits' => $alertesProduits,
        'alertesArticles' => $alertesArticles,
    ]);
}

}

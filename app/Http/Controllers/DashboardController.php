<?php

namespace App\Http\Controllers;

use App\Models\Alerte;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $alertes = Alerte::with('produit')->orderBy('datedeclenchement', 'desc')->get();

        return view('dashboard', compact('alertes'));
    }
}


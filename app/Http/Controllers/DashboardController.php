<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\AlerteProduit;
use App\Models\AlerteArticle;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();

        // Initialisation des collections vides par défaut
        $alertesProduits = collect();
        $alertesArticles = collect();

        // Logique selon rôle et affectation
        if ($user->hasRole('admin')) {
            $alertesProduits = AlerteProduit::with('produit')
                ->orderBy('datedeclenchement', 'desc')
                ->get();

            $alertesArticles = AlerteArticle::with('article')
                ->orderBy('datedeclenchement', 'desc')
                ->get();

        } elseif ($user->hasRole('magasinier_technique') && $user->magasin_affecte === 'technique') {
            $alertesProduits = AlerteProduit::with('produit')
                ->orderBy('datedeclenchement', 'desc')
                ->get();

        } elseif ($user->hasRole('magasinier_collation') && $user->magasin_affecte === 'collation') {
            $alertesArticles = AlerteArticle::with('article')
                ->orderBy('datedeclenchement', 'desc')
                ->get();
        }

        return view('dashboard', [
            'alertesProduits' => $alertesProduits,
            'alertesArticles' => $alertesArticles,
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\AlerteProduit;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;


class AlerteProduitController extends Controller
{
    /**
     * Affiche la liste des alertes produits (dashboard ou page alertes).
     */
    public function index()
    {
        // Récupérer les alertes les plus récentes avec le produit lié

        $user = auth()->user();

        // Vérifie si l'utilisateur est autorisé
        if (!($user->hasRole('admin') || ($user->hasRole('magasinier_technique') && $user->magasin_affecte === 'technique'))) {
            return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à voir les alertes des produits.');
        }
        $alertesProduits = AlerteProduit::with('produit')
            ->orderByDesc('datedeclenchement')
            ->get();

        // Compter le nombre total d'alertes
        $nbAlertes = $alertesProduits->count();

        // Retourner la vue avec les données
        return view('alertes-produits.index', compact('alertesProduits', 'nbAlertes'));
    }

    /**
     * Affiche une alerte produit précise (par exemple, pour voir le détail).
     */
    public function show($alerteProd_id)
    {
        $user = auth()->user();

        // Vérifie si l'utilisateur est autorisé
        if (!($user->hasRole('admin') || ($user->hasRole('magasinier_technique') && $user->magasin_affecte === 'technique'))) {
            return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à voir les alertes des produits.');
        } 
        $alerte = AlerteProduit::with('produit')
            ->where('alerteProd_id', $alerteProd_id)
            ->firstOrFail();

        return view('alertes-produits.show', compact('alerte'));
    }

    // Tu peux ajouter d'autres méthodes CRUD si besoin (create, update, delete)

    public function destroy(AlerteProduit $alerte): RedirectResponse
    {
        $user = auth()->user();

        // Vérifie si l'utilisateur est autorisé
        if (!($user->hasRole('magasinier_technique') && $user->magasin_affecte === 'technique')) {
            return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à supprimé les alertes du produits.');
        }

        $alerte->delete();

        return redirect()->route('alertes-produits.index')
            ->with('success', 'L’alerte a bien été supprimée.');
    }
}

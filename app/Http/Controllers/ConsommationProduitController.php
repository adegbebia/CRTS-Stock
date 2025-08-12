<?php

namespace App\Http\Controllers;

use App\Models\ConsommationProduit;
use App\Models\Produit;
use App\Models\MouvementProduit;
use Illuminate\Http\Request;
use App\Http\Requests\ConsommationRequest;

class ConsommationProduitController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        if (!($user->hasRole('magasinier_technique') && $user->magasin_affecte === 'technique')) {
            return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à accéder à cette page.');
        }

        return redirect()->route('consommations-produits.create');
    }

    public function create(Request $request)
{
    $user = auth()->user();

    if (!($user->hasRole('magasinier_technique') && $user->magasin_affecte === 'technique')) {
        return redirect()->route('produits.index')->with('error', 'Vous n\'êtes pas autorisé à accéder à cette page.');
    }
    $produits = Produit::all();
    $produit_id = $request->query('produit_id');
    $annee = $request->query('annee', date('Y'));
    $search = $request->query('search');
    $consommations_mensuelles = array_fill(1, 12, 0);

    // Récupération des consommations annuelles, filtrées par libellé
    $consommationsQuery = ConsommationProduit::with('produit')->orderBy('annee', 'desc');

    if (!empty($search)) {
        $produitIds = Produit::where('libelle', 'like', '%' . $search . '%')->pluck('produit_id');
        $consommationsQuery->whereIn('produit_id', $produitIds);
    }

    $consommations = $consommationsQuery->paginate(2);

    // Si un produit est sélectionné, on calcule ses consommations mensuelles
    if (!empty($produit_id)) {
        $resultats = MouvementProduit::selectRaw("CAST(strftime('%m', date) AS INTEGER) AS mois, SUM(quantite_sortie) AS total")
            ->where('produit_id', $produit_id)
            ->whereYear('date', $annee)
            ->where('quantite_sortie', '>', 0)
            ->groupByRaw("CAST(strftime('%m', date) AS INTEGER)")
            ->get();

        foreach ($resultats as $resultat) {
            $mois = $resultat->mois;
            $total = $resultat->total;
            $consommations_mensuelles[$mois] = $total;
        }
    }

    return view('consommations-produits.create', compact(
        'produits',
        'consommations',
        'produit_id',
        'annee',
        'consommations_mensuelles',
        'search'
    ));
}


    public function store(ConsommationRequest $request)
    {
        $user = auth()->user();
        if (!($user->hasRole('magasinier_technique') && $user->magasin_affecte === 'technique')) {
            return redirect()->route('consommations-produits.create')->with('error', 'Accès refusé.');
        }

        $data = $request->validated();
        ConsommationProduit::create($data);

        ConsommationProduit::recalcForProductYear($data['produit_id'], $data['annee']);

        return redirect()->route('consommations-produits.create', [
            'produit_id' => $data['produit_id'],
            'annee' => $data['annee']
        ])->with('success', 'Consommation créée avec succès.');
    }

    public function edit(ConsommationProduit $consommations_produit)
    {
        $user = auth()->user();
        if (!($user->hasRole('magasinier_technique') && $user->magasin_affecte === 'technique')) {
            return redirect()->route('consommations-produits.create')->with('error', 'Accès refusé.');
        }

        $produits = Produit::all();

        return view('consommations-produits.edit', [
            'consommation' => $consommations_produit,
            'produits' => $produits
        ]);
    }

    public function update(ConsommationRequest $request, ConsommationProduit $consommations_produit)
    {
        $user = auth()->user();
        if (!($user->hasRole('magasinier_technique') && $user->magasin_affecte === 'technique')) {
            return redirect()->route('consommations-produits.create')->with('error', 'Accès refusé.');
        }

        $data = $request->validated();
        $consommations_produit->update($data);

        ConsommationProduit::recalcForProductYear($data['produit_id'], $data['annee']);

        return redirect()->route('consommations-produits.create', [
            'produit_id' => $data['produit_id'],
            'annee' => $data['annee']
        ])->with('success', 'Consommation mise à jour avec succès.');
    }

    public function destroy(ConsommationProduit $consommations_produit)
    {
        $user = auth()->user();
        if (!($user->hasRole('magasinier_technique') && $user->magasin_affecte === 'technique')) {
            return redirect()->route('consommations-produits.create')->with('error', 'Accès refusé.');
        }

        $produit_id = $consommations_produit->produit_id;
        $annee = $consommations_produit->annee;

        $consommations_produit->delete();

        //ConsommationProduit::recalcForProductYear($produit_id, $annee);

        return redirect()->route('consommations-produits.create', [
            'produit_id' => $produit_id,
            'annee' => $annee
        ])->with('success', 'Consommation supprimée avec succès.');
    }
}

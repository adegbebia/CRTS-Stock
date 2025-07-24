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
        return redirect()->route('consommations-produits.create');
    }

    public function create(Request $request)
    {
        $produits = Produit::all();
        $produit_id = $request->query('produit_id');
        $annee = $request->query('annee') ?? date('Y');

        $consommations_mensuelles = [];
        $afficher_formulaire = false;

        if ($produit_id) {
            // Vérifie si une conso existe déjà pour ce produit/année
            $deja_enregistre = ConsommationProduit::where('produit_id', $produit_id)
                                ->where('annee', $annee)
                                ->exists();

            if (!$deja_enregistre) {
                $afficher_formulaire = true;

                // Pré-calculer la conso mensuelle à afficher dans le formulaire
                $mensuelles = MouvementProduit::selectRaw("
                        CAST(strftime('%m', date) AS INTEGER) AS mois,
                        COALESCE(SUM(quantite_sortie), 0) AS total")
                    ->where('produit_id', $produit_id)
                    ->whereYear('date', $annee)
                    ->where('quantite_sortie', '>', 0)
                    ->groupByRaw("CAST(strftime('%m', date) AS INTEGER)")
                    ->pluck('total', 'mois');

                $consommations_mensuelles = array_fill(1, 12, 0);

                foreach ($mensuelles as $mois => $total) {
                    $consommations_mensuelles[$mois] = $total;
                }
            }
        }

        $consommations = ConsommationProduit::with('produit')
            ->orderBy('annee', 'desc')
            ->get();

        return view('consommations-produits.create', compact(
            'produits',
            'consommations',
            'produit_id',
            'annee',
            'consommations_mensuelles',
            'afficher_formulaire'
        ));
    }

    public function store(ConsommationRequest $request)
    {
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
        $produits = Produit::all();

        return view('consommations-produits.edit', [
            'consommation' => $consommations_produit,
            'produits' => $produits
        ]);
    }

    public function update(ConsommationRequest $request, ConsommationProduit $consommations_produit)
    {
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

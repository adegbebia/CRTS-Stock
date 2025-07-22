<?php

namespace App\Http\Controllers;

use App\Models\ConsommationProduit;
use App\Models\Produit;
use App\Models\MouvementProduit;
use Illuminate\Http\Request;
use App\Http\Requests\ConsommationRequest;

class ConsommationProduitController extends Controller
{
    /* /consommations → redirige vers create */
    public function index()
    {
        return redirect()->route('consommations.create');
    }

    /* Formulaire + tableau */
    public function create(Request $request)
    {
        $produits = Produit::all();

        $produit_id = $request->query('produit_id');
       
        $annee = $request->query('annee') ?? date('Y');
         //dd($annee);


        // Tableau mensuel initialisé à 0 (keys 1‑12)
        $consommations_mensuelles = array_fill(1, 12, 0);
       

        if ($produit_id) {
            // Sorties mensuelles → SQLite : strftime('%m', date)
            $mensuelles = Mouvement::selectRaw("
                    CAST(strftime('%m', date) AS INTEGER)  AS mois,
                    COALESCE(SUM(quantite_sortie),0)      AS total")
                ->where('produit_id', $produit_id)
                ->whereYear('date', $annee)           
                ->where('quantite_sortie', '>', 0)
                ->groupByRaw("CAST(strftime('%m', date) AS INTEGER)")
                ->pluck('total', 'mois');             

            foreach ($mensuelles as $mois => $total) {
                $consommations_mensuelles[$mois] = $total;
            }
        }

        // Toutes les consommations enregistrées (pour le tableau du bas)
        $consommations = Consommation::with('produit')
                          ->orderBy('annee', 'desc')
                          ->get();

        return view('consommations.create', compact(
            'produits',
            'consommations',
            'produit_id',
            'annee',
            'consommations_mensuelles'
        ));
    }

    /* Enregistrer */
    public function store(ConsommationRequest $request)
    {
        $data = $request->validated();
        Consommation::create($data);

        // Recalcule immédiatement depuis les mouvements (cohérence)
        Consommation::recalcForProductYear($data['produit_id'], $data['annee']);

        return redirect()->route('consommations.create',
            ['produit_id' => $data['produit_id'], 'annee' => $data['annee']]);
    }

    /* Formulaire d’édition */
    public function edit(Consommation $consommation)
    {
        $produits = Produit::all();
        return view('consommations.edit', compact('consommation', 'produits'));
    }

    /* Mettre à jour */
    public function update(ConsommationRequest $request, Consommation $consommation)
    {
        $data = $request->validated();
        $consommation->update($data);

        Consommation::recalcForProductYear($data['produit_id'], $data['annee']);

        return redirect()->route('consommations.create',
            ['produit_id' => $data['produit_id'], 'annee' => $data['annee']]);
    }

    /* Supprimer */
    public function destroy(Consommation $consommation)
    {
        $produit_id = $consommation->produit_id;
        $annee      = $consommation->annee;

        $consommation->delete();

        // Recalcul après suppression
        Consommation::recalcForProductYear($produit_id, $annee);

        return redirect()->route('consommations.create',
            ['produit_id' => $produit_id, 'annee' => $annee]);
    }
}

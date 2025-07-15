<?php

namespace App\Http\Controllers;

use App\Models\Mouvement;
use App\Models\Produit;
use App\Http\Requests\MouvementRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MouvementController extends Controller
{
    /* /mouvements  → redirige vers create (page principale) */
    public function index()
    {
        return redirect()->route('mouvements.create');
    }

    public function create(Request $request)
{
    $produits = Produit::all();

    $produitSelectionne = $request->query('produit'); // ex: produit=123

    if ($produitSelectionne) {
        // On filtre les mouvements pour ce produit uniquement
        $mouvements = Mouvement::where('produit_id', $produitSelectionne)->latest()->get();
    } else {
        // Tous les mouvements
        $mouvements = Mouvement::latest()->get();
    }

    return view('mouvements.create', compact('produits', 'produitSelectionne', 'mouvements'));
}


    /* Enregistrer un mouvement */
    public function store(MouvementRequest $request)
    {
        //dd($request->all());
        $data    = $request->validated();
        $produit = Produit::findOrFail($data['produit_id']);

        /* ---- Gestion du stock ---- */
        $entree  = $data['quantite_entree']  ?? 0;
        $sortie  = $data['quantite_sortie'] ?? 0;
        $avarie  = $data['avarie']          ?? 0;

        $produit->quantitestock += $entree - $sortie;
        $produit->save();

        $stockJour = $produit->quantitestock - $avarie;

        Mouvement::create([
            'produit_id'         => $produit->produit_id,
            'date'               => Carbon::now()->toDateString(),
            'origine'            => $data['origine'] ?? null,
            'quantite_commandee' => $data['quantite_commandee'],
            'quantite_entree'    => $entree ?: null,
            'quantite_sortie'    => $sortie ?: null,
            'stock_debut_mois'   => $data['stock_debut_mois'],
            'avarie'             => $avarie ?: null,
            'stock_jour'         => $stockJour,
            'observation'        => $data['observation'] ?? null,
        ]);

        /* Retour sur create avec le produit présélectionné */
        return redirect()->route('mouvements.create', ['produit' => $produit->produit_id]);
    }

    /* Formulaire d’édition */
    public function edit(Mouvement $mouvement)
    {
        $produits = Produit::all();
        return view('mouvements.edit', compact('mouvement', 'produits'));
    }

    /* Mettre à jour */
    public function update(MouvementRequest $request, Mouvement $mouvement)
    {
        $data    = $request->validated();
        $produit = $mouvement->produit;

        /* Retirer l’ancien impact du stock */
        $ancienImpact = ($mouvement->quantite_entree ?? 0) - ($mouvement->quantite_sortie ?? 0);
        $produit->quantitestock -= $ancienImpact;

        /* Calcul du nouvel impact */
        $newEntree  = $data['quantite_entree']  ?? 0;
        $newSortie  = $data['quantite_sortie'] ?? 0;
        $newImpact  = $newEntree - $newSortie;
        $produit->quantitestock += $newImpact;
        $produit->save();

        $avarie    = $data['avarie'] ?? 0;
        $stockJour = $produit->quantitestock - $avarie;

        $mouvement->update([
            'date'               => Carbon::now()->toDateString(),
            'origine'            => $data['origine'] ?? null,
            'quantite_commandee' => $data['quantite_commandee'],
            'quantite_entree'    => $newEntree ?: null,
            'quantite_sortie'    => $newSortie ?: null,
            'stock_debut_mois'   => $data['stock_debut_mois'],
            'avarie'             => $avarie ?: null,
            'stock_jour'         => $stockJour,
            'observation'        => $data['observation'] ?? null,
        ]);

        return redirect()->route('mouvements.create', ['produit' => $produit->produit_id]);
    }

    /* Supprimer */
    public function destroy(Mouvement $mouvement)
    {
        $produit = $mouvement->produit;
        $impact  = ($mouvement->quantite_entree ?? 0) - ($mouvement->quantite_sortie ?? 0);
        $produit->quantitestock -= $impact;
        $produit->save();

        $mouvement->delete();
        return redirect()->route('mouvements.create', ['produit' => $produit->produit_id]);
    }

    /* Filtrer les mouvements par produit (si besoin d’URL dédiée) */
    public function filterByProduit($produit_id)
    {
        return redirect()->route('mouvements.create', ['produit' => $produit_id]);
    }
}

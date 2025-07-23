<?php

namespace App\Http\Controllers;

use App\Models\MouvementProduit;
use App\Models\Produit;
use App\Http\Requests\MouvementRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MouvementProduitController extends Controller
{
    public function index()
    {
        return redirect()->route('mouvements-produits.create');
    }

    public function create(Request $request)
    {
        $produits = Produit::all();
        $produitSelectionne = $request->query('produit'); // ex: ?produit=3

        if ($produitSelectionne) {
            $mouvements = MouvementProduit::where('produit_id', $produitSelectionne)->latest()->get();
        } else {
            $mouvements = MouvementProduit::latest()->get();
        }

        return view('mouvements-produits.create', compact('produits', 'produitSelectionne', 'mouvements'));
    }

    public function store(MouvementRequest $request)
    {
        $data = $request->validated();
        $produit = Produit::findOrFail($data['produit_id']);

        $entree = $data['quantite_entree'] ?? 0;
        $sortie = $data['quantite_sortie'] ?? 0;
        $avarie = $data['avarie'] ?? 0;

        $produit->quantitestock += $entree - $sortie;
        $produit->save();

        $stockJour = $produit->quantitestock - $avarie;

        MouvementProduit::create([
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

        return redirect()->route('mouvements-produits.create', ['produit' => $produit->produit_id]);
    }

    public function edit(MouvementProduit $mouvements_produit)
    {
        $produits = Produit::all();

        return view('mouvements-produits.edit', [
            'mouvement' => $mouvements_produit,
            'produits'  => $produits
        ]);
    }

    public function update(MouvementRequest $request, MouvementProduit $mouvements_produit)
    {
        $data = $request->validated();
        $produit = $mouvements_produit->produit;

        $ancienImpact = ($mouvements_produit->quantite_entree ?? 0) - ($mouvements_produit->quantite_sortie ?? 0);
        $produit->quantitestock -= $ancienImpact;

        $newEntree = $data['quantite_entree'] ?? 0;
        $newSortie = $data['quantite_sortie'] ?? 0;
        $newImpact = $newEntree - $newSortie;
        $produit->quantitestock += $newImpact;
        $produit->save();

        $avarie = $data['avarie'] ?? 0;
        $stockJour = $produit->quantitestock - $avarie;

        $mouvements_produit->update([
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

        return redirect()->route('mouvements-produits.create', ['produit' => $produit->produit_id]);
    }

    public function destroy(MouvementProduit $mouvements_produit)
    {
        $produit = $mouvements_produit->produit;
        $impact  = ($mouvements_produit->quantite_entree ?? 0) - ($mouvements_produit->quantite_sortie ?? 0);

        $produit->quantitestock -= $impact;
        $produit->save();

        $mouvements_produit->delete();

        return redirect()->route('mouvements-produits.create', ['produit' => $produit->produit_id]);
    }

    public function filterByProduit($produit_id)
    {
        return redirect()->route('mouvements-produits.create', ['produit' => $produit_id]);
    }
}

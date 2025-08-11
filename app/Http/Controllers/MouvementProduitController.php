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
        $user = auth()->user();

        if (!($user->hasRole(['magasinier_technique','admin']) && $user->magasin_affecte !== 'admin' || $user->magasin_affecte !== 'technique')) {
            return redirect()->route('produits.index')->with('error', 'Vous n\'êtes pas autorisé à accéder à cette page.');
        }

        return redirect()->route('mouvements-produits.create');
    }

    public function create(Request $request)
        {
            $user = auth()->user();

            if (!($user->hasRole('magasinier_technique') && $user->magasin_affecte === 'technique')) {
                return redirect()->route('produits.index')->with('error', 'Vous n\'êtes pas autorisé à accéder à cette page.');
            }

            $produits = Produit::all();
            $produitSelectionne = $request->query('produit');
            $date = $request->query('date');

            // Construction de la requête
            $query = MouvementProduit::with('produit')->latest();

            if ($produitSelectionne) {
                $query->where('produit_id', $produitSelectionne);
            }

            if ($date) {
                $query->whereDate('date', $date);
            }

            $mouvements = $query->paginate(2);

            return view('mouvements-produits.create', compact('produits', 'produitSelectionne', 'date', 'mouvements'));
        }


    public function store(MouvementRequest $request)
    {
        $user = auth()->user();

        if (!($user->hasRole('magasinier_technique') && $user->magasin_affecte === 'technique')) {
            return redirect()->route('produits.index')->with('error', 'Vous n\'êtes pas autorisé à accéder à cette page.');
        }

        $data = $request->validated();
        $produit = Produit::findOrFail($data['produit_id']);

        $entree = $data['quantite_entree'] ?? 0;
        $sortie = $data['quantite_sortie'] ?? 0;
        $avarie = $data['avarie'] ?? 0;

        // ✅ Vérifier le stock AVANT de modifier
        if ($sortie > $produit->quantitestock) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Quantité en stock insuffisante pour cette sortie. Stock disponible : ' . $produit->quantitestock);
        }

        // ✅ Maintenant qu'on est sûr, appliquer les modifications
        $produit->quantitestock += $entree - $sortie;
        $produit->save();

        $stockJour = $produit->quantitestock - $avarie;

        MouvementProduit::create([
            'produit_id'         => $produit->produit_id,
            'date'               => Carbon::now()->toDateString(),
            'origine'            => $data['origine'] ?? null,
            'quantite_commandee' => $data['quantite_commandee']?? null,
            'quantite_entree'    => $entree ?: null,
            'quantite_sortie'    => $sortie ?: null,
            // 'stock_debut_mois'   => $data['stock_debut_mois'],
            'avarie'             => $avarie ?: null,
            'stock_jour'         => $stockJour,
            'observation'        => $data['observation'] ?? null,
        ]);

        return redirect()->route('mouvements-produits.create', ['produit' => $produit->produit_id])
            ->with('success', 'Mouvement créé avec succès.');
    }

    public function edit(MouvementProduit $mouvements_produit)
    {
        $user = auth()->user();

        if (!($user->hasRole('magasinier_technique') && $user->magasin_affecte === 'technique')) {
            return redirect()->route('produits.index')->with('error', 'Vous n\'êtes pas autorisé à accéder à cette page.');
        }

        $produits = Produit::all();

        return view('mouvements-produits.edit', [
            'mouvement' => $mouvements_produit,
            'produits'  => $produits
        ]);
    }

    public function update(MouvementRequest $request, MouvementProduit $mouvements_produit)
    {
        $user = auth()->user();

        if (!($user->hasRole('magasinier_technique') && $user->magasin_affecte === 'technique')) {
            return redirect()->route('produits.index')->with('error', 'Vous n\'êtes pas autorisé à accéder à cette page.');
        }

        $data = $request->validated();
        $produit = $mouvements_produit->produit;

        // Annuler l'effet de l'ancien mouvement sur le stock
        $ancienEntree = $mouvements_produit->quantite_entree ?? 0;
        $ancienSortie = $mouvements_produit->quantite_sortie ?? 0;
        $produit->quantitestock -= ($ancienEntree - $ancienSortie);

        // Avant d’appliquer les nouvelles valeurs, on vérifie la validité
        $newEntree = $data['quantite_entree'] ?? 0;
        $newSortie = $data['quantite_sortie'] ?? 0;

        $stockTemporaire = $produit->quantitestock; // stock réel après suppression de l’ancien mouvement

        if ($newSortie > $stockTemporaire) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Quantité en stock insuffisante pour cette sortie. Stock disponible : ' . $stockTemporaire);
        }

        // Mise à jour effective du stock
        $produit->quantitestock += ($newEntree - $newSortie);
        $produit->save();

        $avarie = $data['avarie'] ?? 0;
        $stockJour = $produit->quantitestock - $avarie;

        $mouvements_produit->update([
            'date'               => Carbon::now()->toDateString(),
            'origine'            => $data['origine'] ?? null,
            'quantite_commandee' => $data['quantite_commandee']?? null,
            'quantite_entree'    => $newEntree ?: null,
            'quantite_sortie'    => $newSortie ?: null,
            // 'stock_debut_mois'   => $data['stock_debut_mois'],
            'avarie'             => $avarie ?: null,
            'stock_jour'         => $stockJour,
            'observation'        => $data['observation'] ?? null,
        ]);

        return redirect()->route('mouvements-produits.create', ['produit' => $produit->produit_id])
            ->with('success', 'Mouvement mis à jour avec succès.');
    }


    public function destroy(MouvementProduit $mouvements_produit)
    {
        $user = auth()->user();

        if (!($user->hasRole('magasinier_technique') && $user->magasin_affecte === 'technique')) {
            return redirect()->route('produits.index')->with('error', 'Vous n\'êtes pas autorisé à accéder à cette page.');
        }

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

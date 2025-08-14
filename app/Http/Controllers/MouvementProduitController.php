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

        if (!($user->hasRole(['magasinier_technique','admin']))) {
            return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à accéder à cette page.');
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
        $nombre_rupture_stock = $data['nombre_rupture_stock'] ?? 0;
        // ✅ Vérifier le stock AVANT de modifier
        if ($sortie > $produit->quantitestock) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Quantité en stock insuffisante pour cette sortie. Stock disponible : ' . $produit->quantitestock);
        }

       
        $produit->quantitestock += $entree - $sortie - $avarie; 
        $produit->save();
        $stockJour = $article->quantitestock ;

        MouvementProduit::create([
            'produit_id'         => $produit->produit_id,
            'date'               => Carbon::now()->toDateString(),
            'origine'            => $data['origine'] ?? null,
            'quantite_commandee' => $data['quantite_commandee']?? null,
            'quantite_entree'    => $entree ?: null,
            'quantite_sortie'    => $sortie ?: null,
            // 'stock_debut_mois'   => $data['stock_debut_mois'],
            'avarie'             => $avarie ?: null,
            'nombre_rupture_stock' => $nombre_rupture_stock ?: null,
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
            return redirect()->route('produits.index')
                            ->with('error', 'Vous n\'êtes pas autorisé à accéder à cette page.');
        }

        $data = $request->validated();
        $produit = $mouvements_produit->produit;

        // Annuler l'effet de l'ancien mouvement sur le stock
        $ancienEntree  = $mouvements_produit->quantite_entree ?? 0;
        $ancienSortie  = $mouvements_produit->quantite_sortie ?? 0;
        $ancienAvarie  = $mouvements_produit->avarie ?? 0;
        $produit->quantitestock -= ($ancienEntree - $ancienSortie - $ancienAvarie);

        // Nouvelles valeurs
        $newEntree  = $data['quantite_entree'] ?? 0;
        $newSortie  = $data['quantite_sortie'] ?? 0;
        $newAvarie  = $data['avarie'] ?? 0;

        // Vérification du stock avant application
        if ($newSortie > $produit->quantitestock) {
            return redirect()->back()
                            ->withInput()
                            ->with('error', 'Quantité en stock insuffisante pour cette sortie. Stock disponible : ' . $produit->quantitestock);
        }

        // Appliquer le nouveau mouvement
        $produit->quantitestock += ($newEntree - $newSortie - $newAvarie);
        $produit->save();

        $avarie = $data['avarie'] ?? 0;
        $nombre_rupture_stock = $data['nombre_rupture_stock'] ?? 0;
        $stockJour = $produit->quantitestock - $avarie;

        // Mise à jour du mouvement
        $mouvements_produit->update([
            'date'               => Carbon::now()->toDateString(),
            'origine'            => $data['origine'] ?? null,
            'quantite_commandee' => $data['quantite_commandee'] ?? null,
            'quantite_entree'    => $newEntree ?: null,
            'quantite_sortie'    => $newSortie ?: null,
            // 'stock_debut_mois'   => $data['stock_debut_mois'],
            'avarie'             => $avarie ?: null,
            'nombre_rupture_stock'  => $nombre_rupture_stock ?: null,
            'stock_jour'         => $stockJour,
            'avarie'             => $newAvarie ?: null,
            'stock_jour'         => $produit->quantitestock,
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

<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\ProduitRequest;
use Carbon\Carbon;

class ProduitController extends Controller
{
    public function index()
    {
        $produits = Produit::all();
        $users = User::all(); 
        return view('produits.index', compact('produits', 'users'));
    }


    public function create()
        {
            $produits = Produit::all();
            $users = User::all(); 
            return view('produits.create', compact('produits', 'users'));
        }


    public function store(ProduitRequest $request)
    {
        $validated = $request->validated();

        // Vérifier s'il existe un produit avec le même codeproduit mais un libellé différent
        $produitAvecCode = Produit::where('codeproduit', $validated['codeproduit'])->first();

        if ($produitAvecCode && $produitAvecCode->libelle !== $validated['libelle']) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['codeproduit' => 'Ce code produit est déjà utilisé pour un autre libellé. Veuillez en choisir un autre.']);
        }

        // Vérifier s'il existe déjà un produit avec le même libellé et conditionnement
        $produitExistant = Produit::where('libelle', $validated['libelle'])
                            ->where('conditionnement', $validated['conditionnement'])
                            ->first();

        if ($produitExistant) {
            // Calcul manuel de la nouvelle quantité
            $nouvelleQuantite = $produitExistant->quantitestock + $validated['quantitestock'];
            $produitExistant->quantitestock = $nouvelleQuantite;
            $produitExistant->save();

            return redirect()->route('produits.index')
                ->with('success', 'Produit déjà existant. Quantité mise à jour avec succès.');
        }

        // Ajouter la date de création du produit
        $validated['date'] = Carbon::now()->toDateString();

        // Création du nouveau produit
        Produit::create($validated);

        return redirect()->route('produits.index')
            ->with('success', 'Produit ajouté avec succès.');
    }

    public function show(Produit $produit)
    {
        return view('produits.show', compact('produit'));
    }

    public function edit(Produit $produit)
    {
        return view('produits.edit', compact('produit'));
    }

    public function update(ProduitRequest $request, Produit $produit)
    {
        $validated = $request->validated();

        $produit->update($validated);

        return redirect()->route('produits.index')->with('success', 'Produit mis à jour avec succès.');
    }

    public function destroy(Produit $produit)
    {
        $produit->alertes()->delete();
        $produit->delete();

        return redirect()->route('produits.index')->with('success', 'Produit supprimé avec succès.');
    }
}

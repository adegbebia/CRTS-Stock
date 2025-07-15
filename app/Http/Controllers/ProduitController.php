<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\ProduitRequest;

class ProduitController extends Controller
{
    public function index()
    {
        $produits = Produit::all();
        return view('produits.index', compact('produits'));
    }

    public function create()
    {
        $users = User::all();
        return view('produits.create', compact('users')); 
    }

    public function store(ProduitRequest $request)
            {
                $validated = $request->validated();

                // Vérifie si un produit identique existe déjà
                $produitExistant = Produit::where('codeproduit', $validated['codeproduit'])
                                    ->where('libelle', $validated['libelle'])
                                    ->where('lot', $validated['lot'])
                                    ->first();

                if ($produitExistant) {
                    // Mise à jour manuelle de la quantité
                    $nouvelleQuantite = $produitExistant->quantitestock + $validated['quantitestock'];
                    $produitExistant->update(['quantitestock' => $nouvelleQuantite]);

                    return redirect()->route('produits.index')
                        ->with('success', 'Le produit existait déjà. Sa quantité a été augmentée.');
                } else {
                    // Création d’un nouveau produit
                    Produit::create($validated);

                    return redirect()->route('produits.index')
                        ->with('success', 'Produit ajouté avec succès.');
                }
            }



    public function show(Produit $produit)
    {
        return view('produits.show', compact('produit'));
    }

    public function edit(Produit $produit)
    {
        $users = User::all();
        return view('produits.edit', compact('produit', 'users'));
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

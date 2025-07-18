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
        // Vérifiez si l'utilisateur a la permission de créer un produit
        if (auth()->user()->can('produits-create')) {
            $users = User::all();
            return view('produits.create', compact('users')); 
        }

        return redirect()->route('produits.index')->with('error', 'Vous n\'avez pas la permission d\'ajouter un produit.');
    }

    public function store(ProduitRequest $request)
    {
        // Vérifiez si l'utilisateur a la permission de créer un produit
        if (!auth()->user()->can('produits-create')) {
            return redirect()->route('produits.index')->with('error', 'Vous n\'avez pas la permission d\'ajouter un produit.');
        }

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
        // Vérifiez si l'utilisateur a la permission de modifier un produit
        if (auth()->user()->can('produits-edit')) {
            $users = User::all();
            return view('produits.edit', compact('produit', 'users'));
        }

        return redirect()->route('produits.index')->with('error', 'Vous n\'avez pas la permission de modifier ce produit.');
    }

    public function update(ProduitRequest $request, Produit $produit)
    {
        // Vérifiez si l'utilisateur a la permission de modifier un produit
        if (!auth()->user()->can('produits-edit')) {
            return redirect()->route('produits.index')->with('error', 'Vous n\'avez pas la permission de modifier ce produit.');
        }

        $validated = $request->validated();
        $produit->update($validated);

        return redirect()->route('produits.index')->with('success', 'Produit mis à jour avec succès.');
    }

    public function destroy(Produit $produit)
    {
        // Vérifiez si l'utilisateur a la permission de supprimer un produit
        if (!auth()->user()->can('produits-delete')) {
            return redirect()->route('produits.index')->with('error', 'Vous n\'avez pas la permission de supprimer ce produit.');
        }

        $produit->alertes()->delete();
        $produit->delete();

        return redirect()->route('produits.index')->with('success', 'Produit supprimé avec succès.');
    }
}

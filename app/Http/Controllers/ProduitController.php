<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produit;

class ProduitController extends Controller
{
    public function index()
    {
        $produits = Produit::all();
        return view('produits.index', compact('produits'));
    }

    public function create()
    {
        return view('produits.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'codeproduit'     => 'required|string|max:255',
            'libelle'         => 'required|string|max:255',
            'conditionnement' => 'required|string|max:255',
            'quantitestock'   => 'required|integer',
            'stockmax'        => 'required|integer',
            'stockmin'        => 'required|integer',
            'stocksecurite'   => 'required|integer',
            'dateperemption'  => 'required|date',
            'lot'             => 'required|string|max:255',
            'user_id'         => 'required|integer',
        ]);

        Produit::create($validated);

        return redirect()->route('produits.index')->with('success', 'Produit ajouté avec succès.');
    }

    public function show(Produit $produit)
    {
        return view('produits.show', compact('produit'));
    }

    public function edit(Produit $produit)
    {
        return view('produits.edit', compact('produit'));
    }

    public function update(Request $request, Produit $produit)
    {
        $validated = $request->validate([
            'codeproduit'     => 'required|string|max:255',
            'libelle'         => 'required|string|max:255',
            'conditionnement' => 'required|string|max:255',
            'quantitestock'   => 'required|integer',
            'stockmax'        => 'required|integer',
            'stockmin'        => 'required|integer',
            'stocksecurite'   => 'required|integer',
            'dateperemption'  => 'required|date',
            'lot'             => 'required|string|max:255',
        ]);

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

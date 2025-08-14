<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\ProduitRequest;
use Carbon\Carbon;

class ProduitController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        if (!($user->hasRole(['magasinier_technique', 'admin']))) {
            return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à effectuer cette action.');
        }

        $search = $request->input('search');
        $paginates = 2;
        $query = Produit::query();

        if ($search) {
            $search = strtolower($search);
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(codeproduit) LIKE ?', ["%$search%"])
                    ->orWhereRaw('LOWER(libelle) LIKE ?', ["%$search%"])
                    ->orWhereRaw('LOWER(conditionnement) LIKE ?', ["%$search%"])
                    ->orWhereRaw('CAST(quantitestock AS CHAR) LIKE ?', ["%$search%"])
                    ->orWhereRaw('CAST(stockmax AS CHAR) LIKE ?', ["%$search%"])
                    ->orWhereRaw('CAST(stockmin AS CHAR) LIKE ?', ["%$search%"])
                    ->orWhereRaw('CAST(stocksecurite AS CHAR) LIKE ?', ["%$search%"])
                    ->orWhereRaw('LOWER(dateperemption) LIKE ?', ["%$search%"])
                    ->orWhereRaw('LOWER(lot) LIKE ?', ["%$search%"])
                    ->orWhereRaw('LOWER(date) LIKE ?', ["%$search%"]);
            });
        }

        $produits = $query->paginate($paginates);
        $users = User::all();

        return view('produits.index', compact('produits', 'users'));
    }

    public function create()
    {
        $user = auth()->user();

        if (!($user->hasRole('magasinier_technique') && $user->magasin_affecte === 'technique')) {
            return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à effectuer cette action.');
        }

        $produits = Produit::all();
        $users = User::all();
        return view('produits.create', compact('produits', 'users'));
    }

    public function store(ProduitRequest $request)
{
    $user = auth()->user();

    if (!($user->hasRole('magasinier_technique') && $user->magasin_affecte === 'technique')) {
        return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à effectuer cette action.');
    }

    $validated = $request->validated();
    $validated['codeproduit'] = strtoupper($validated['codeproduit']);
    $validated['libelle'] = ucfirst(strtolower($validated['libelle']));
    $validated['dateperemption'] = $request->input('dateperemption');
    $validated['lot'] = $request->input('lot');

    $produitAvecCode = Produit::where('codeproduit', $validated['codeproduit'])->first();

    if ($produitAvecCode && $produitAvecCode->libelle !== $validated['libelle']) {
        return redirect()->back()
            ->withInput()
            ->withErrors(['codeproduit' => 'Ce code produit est déjà utilisé pour un autre libellé.']);
    }

    $produitExistant = Produit::where('libelle', $validated['libelle'])
        ->where('conditionnement', $validated['conditionnement'])
        ->first();

    if ($produitExistant) {
        // Mise à jour du stock
        $produitExistant->quantitestock += $validated['quantitestock'];

        // Mise à jour des autres champs
        if (isset($validated['stockmax'])) $produitExistant->stockmax = $validated['stockmax'];
        if (isset($validated['stockmin'])) $produitExistant->stockmin = $validated['stockmin'];
        if (isset($validated['stocksecurite'])) $produitExistant->stocksecurite = $validated['stocksecurite'];
        
        $produitExistant->dateperemption = $validated['dateperemption'];
        $produitExistant->lot = $validated['lot'];

        $produitExistant->save();

        return redirect()->route('produits.index')
            ->with('success', 'Produit déjà existant. Stock et informations mis à jour.');
    }

    $validated['date'] = Carbon::now()->toDateString();
    Produit::create($validated);

    return redirect()->route('produits.index')
        ->with('success', 'Produit ajouté avec succès.');
}

    public function show(Produit $produit)
    {
        $user = auth()->user();

        if (!($user->hasRole(['magasinier_technique', 'admin']) && $user->magasin_affecte !== 'admin' || $user->magasin_affecte !== 'technique')) {
            return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à effectuer cette action.');
        }
        return view('produits.show', compact('produit'));
    }

    public function edit(Produit $produit)
    {
        $user = auth()->user();

        if (!($user->hasRole('magasinier_technique') && $user->magasin_affecte === 'technique')) {
            return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à effectuer cette action.');
        }
        return view('produits.edit', compact('produit'));
    }

    public function update(ProduitRequest $request, Produit $produit)
{
    $user = auth()->user();

    if (!($user->hasRole('magasinier_technique') && $user->magasin_affecte === 'technique')) {
        return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à effectuer cette action.');
    }

    if ($produit->user_id !== $user->user_id) {
        return redirect()->back()->with('error', 'Vous ne pouvez mettre à jour que vos propres produits.');
    }

    $validated = $request->validated();
    $validated['codeproduit'] = strtoupper($validated['codeproduit']);
    $validated['libelle'] = ucfirst(strtolower($validated['libelle']));
    $validated['dateperemption'] = $request->input('dateperemption');
    $validated['lot'] = $request->input('lot');

    $produitAvecCode = Produit::where('codeproduit', $validated['codeproduit'])
        ->where('produit_id', '!=', $produit->produit_id)
        ->first();

    if ($produitAvecCode && $produitAvecCode->libelle !== $validated['libelle']) {
        return redirect()->back()
            ->withInput()
            ->withErrors(['codeproduit' => 'Ce code produit est déjà utilisé pour un autre libellé.']);
    }

    $produitExistant = Produit::where('libelle', $validated['libelle'])
        ->where('conditionnement', $validated['conditionnement'])
        ->where('produit_id', '!=', $produit->produit_id)
        ->first();

    if ($produitExistant) {
        $produitExistant->quantitestock += $validated['quantitestock'];

        if (isset($validated['stockmax'])) $produitExistant->stockmax = $validated['stockmax'];
        if (isset($validated['stockmin'])) $produitExistant->stockmin = $validated['stockmin'];
        if (isset($validated['stocksecurite'])) $produitExistant->stocksecurite = $validated['stocksecurite'];

        $produitExistant->dateperemption = $validated['dateperemption'];
        $produitExistant->lot = $validated['lot'];
        
        $produitExistant->save();
        $produit->delete();

        return redirect()->route('produits.index')
            ->with('success', 'Produit fusionné et mis à jour.');
    }

    $produit->update($validated);

    return redirect()->route('produits.index')->with('success', 'Produit mis à jour avec succès.');
}

    public function destroy(Produit $produit)
    {
        $user = auth()->user();

        if (!($user->hasRole('magasinier_technique') && $user->magasin_affecte === 'technique')) {
            return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à effectuer cette action.');
        }

        if ($produit->user_id !== $user->user_id) {
            return redirect()->back()->with('error', 'Vous ne pouvez mettre à jour que vos propres produits.');
        }

        $produit->alertes()->delete();
        $produit->delete();

        return redirect()->route('produits.index')->with('success', 'Produit supprimé avec succès.');
    }
}

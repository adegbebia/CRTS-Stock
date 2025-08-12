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

    // Vérification des droits manuellement
    if (!($user->hasRole(['magasinier_technique', 'admin']))) {
        return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à effectuer cette action.');
    }


    $search = $request->input('search');

    $paginates=2;

    $query = Produit::query();

    // $query->whereRaw('1=0');

    // if ($request->filled('search')) {
    //     $query->where('libelle', 'like', '%' . $request->search . '%');
    // }

    // // Ajout de la pagination ici (10 produits par page)
    // $produits = $query->paginate(10); 
   

    if ($search) {
            $search = strtolower($search);

            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(codeproduit) LIKE ?', ["%$search%"])
                ->orWhereRaw('LOWER(libelle) LIKE ?', ["%$search%"])
                ->orWhereRaw('LOWER(conditionnement) LIKE ?', ["%$search%"])
                ->orWhereRaw('LOWER(quantitestock) LIKE ?', ["%$search%"])
                ->orWhereRaw('LOWER(stockmax) LIKE ?', ["%$search%"])
                ->orWhereRaw('LOWER(stockmin) LIKE ?', ["%$search%"])
                ->orWhereRaw('LOWER(stocksecurite) LIKE ?', ["%$search%"])
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

    // Vérification des droits manuellement
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

    // Vérification des droits manuellement
        if (!($user->hasRole('magasinier_technique') && $user->magasin_affecte === 'technique')) {
            return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à effectuer cette action.');
        }
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
        $user = auth()->user();

    // Vérification des droits manuellement
        if (!($user->hasRole(['magasinier_technique', 'admin']) && $user->magasin_affecte !== 'admin' || $user->magasin_affecte !== 'technique')) {
            return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à effectuer cette action.');
        }
        return view('produits.show', compact('produit'));
    }

    public function edit(Produit $produit)
    {
        $user = auth()->user();

    // Vérification des droits manuellement
        if (!($user->hasRole('magasinier_technique') && $user->magasin_affecte === 'technique')) {
            return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à effectuer cette action.');
        }
        return view('produits.edit', compact('produit'));
    }

    public function update(ProduitRequest $request, Produit $produit)
    {
        $user = auth()->user();

    // Vérification des droits manuellement
        if (!($user->hasRole('magasinier_technique') && $user->magasin_affecte === 'technique')) {
            return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à effectuer cette action.');
        }
        if ($produit->user_id !== $user->user_id) {
            return redirect()->back()->with('error', 'Vous ne pouvez mettre à jour que vos propres produits.');
        }
        $validated = $request->validated();

        $produit->update($validated);

        return redirect()->route('produits.index')->with('success', 'Produit mis à jour avec succès.');
    }

    public function destroy(Produit $produit)
    {
        $user = auth()->user();

    // Vérification des droits manuellement
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

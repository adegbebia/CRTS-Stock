<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\ArticleRequest;
use Carbon\Carbon;


class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        // dd(auth()->user());
        // dd($user->getRoleNames());

        if (!($user->hasRole(['magasinier_collation', 'admin']) && $user->magasin_affecte !== 'admin' || $user->magasin_affecte !== 'collation')) {
        // if (!($user->hasRole(['magasinier_collation', 'admin']))) {

            return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à effectuer cette action.');
        }

        // $query = Article::query();

        // if ($request->filled('search')) {
        //     $query->where('libelle', 'like', '%' . $request->search . '%');
        // }
        
        $search = $request->input('search');

        $paginates=2;

        $query = Article::query();
        
        // $articles = $query->paginate(10); 

        if ($search) {

            $search = strtolower($search);

            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(codearticle) LIKE ?', ["%$search%"])
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

        $articles = $query->paginate($paginates); 

        $users = User::all();

        return view('articles.index', compact('articles','users'));


    }

    public function create()
    {
        $user = auth()->user();

        // Vérification des droits manuellement
        if (!($user->hasRole('magasinier_collation') && $user->magasin_affecte === 'collation')) {
            return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à effectuer cette action.');
        }
        
        $articles = Article::all();
        $users = User::all();
        return view('articles.create', compact('articles','users')); 
    }

    public function store(ArticleRequest $request)
    {
        $user = auth()->user();

        if (!($user->hasRole('magasinier_collation') && $user->magasin_affecte === 'collation')) {
            return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à effectuer cette action.');
        }

        $validated = $request->validated();

        // Vérifier s'il existe un article avec le même codearticle mais un libellé différent
        $articleAvecCode = Article::where('codearticle', $validated['codearticle'])->first();

        if($articleAvecCode && $articleAvecCode->libelle !== $validated['libelle']) {

            return redirect()->back()
                ->withInput()
                ->withErrors(['codearticle' => 'Ce code article est déjà utilisé pour un autre libellé. Veuillez en choisir un autre.']);

        }
        
        // Vérifier s'il existe déjà un article avec le même libellé et conditionnement
        $articleExistant=Article::where('libelle', $validated['libelle'])
                            ->where('conditionnement', $validated['conditionnement'])
                            ->first();               
        if ($articleExistant) {
            // Calcul manuel de la nouvelle quantité
            $nouvelleQuantite = $articleExistant->quantitestock + $validated['quantitestock'];
            $articleExistant->quantitestock = $nouvelleQuantite;
            $articleExistant->save();


            return redirect()->route('articles.index')
                ->with('success', 'L’article déjà existant .  Quantité mise à jour avec succès.');
        } 

        // Ajouter la date de création du produit
        $validated['date'] = Carbon::now()->toDateString();
        // Création d’un nouveau article
        Article::create($validated);

        return redirect()->route('articles.index')
            ->with('success', 'Article ajouté avec succès.');
        
    }

    public function show(Article $article)
    {
        $user = auth()->user();

    // Vérification des droits manuellement
        if (!($user->hasRole(['magasinier_collation', 'admin']) && $user->magasin_affecte !== 'admin' || $user->magasin_affecte !== 'collation')) {
            return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à effectuer cette action.');
        }  
        return view('articles.show', compact('article'));
    }

    public function edit(Article $article)
    {

        $user = auth()->user();

    // Vérification des droits manuellement
        if (!($user->hasRole('magasinier_collation') && $user->magasin_affecte === 'collation')) {
            return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à effectuer cette action.');
        }
        return view('articles.edit', compact('article'));
    }

    public function update(ArticleRequest $request, Article $article)
    {
        $user = auth()->user();

        if (!($user->hasRole('magasinier_collation') && $user->magasin_affecte === 'collation')) {
            return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à effectuer cette action.');
        }

        if ($article->user_id !== $user->user_id) {
            return redirect()->back()->with('error', 'Vous ne pouvez mettre à jour que vos propres articles.');
        }

        $validated = $request->validated();

        $article->update($validated);

        return redirect()->route('articles.index')->with('success', 'Article mis à jour avec succès.');
    }

    public function destroy(Article $article)
    {
        $user = auth()->user();

        if (!($user->hasRole('magasinier_collation') && $user->magasin_affecte === 'collation')) {
            return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à effectuer cette action.');
        }

        if ($article->user_id !== $user->user_id) {
            return redirect()->back()->with('error', 'Vous ne pouvez mettre à jour que vos propres articles.');
        }

        $article->alertes()->delete();
        $article->delete();

        return redirect()->route('articles.index')->with('success', 'Article supprimé avec succès.');
    }
}

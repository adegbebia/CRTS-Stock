<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\ArticleRequest;
use Carbon\Carbon;


class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::all();
        $users = User::all();
        return view('articles.index', compact('articles','users'));
    }

    public function create()
    {
        
        $articles = Article::all();
        $users = User::all();
        return view('articles.create', compact('articles','users')); 
    }

    public function store(ArticleRequest $request)
    {
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
        return view('articles.show', compact('article'));
    }

    public function edit(Article $article)
    {
        
        return view('articles.edit', compact('article'));
    }

    public function update(ArticleRequest $request, Article $article)
    {
        $validated = $request->validated();

        $article->update($validated);

        return redirect()->route('articles.index')->with('success', 'Article mis à jour avec succès.');
    }

    public function destroy(Article $article)
    {
        $article->alertes()->delete();
        $article->delete();

        return redirect()->route('articles.index')->with('success', 'Article supprimé avec succès.');
    }
}

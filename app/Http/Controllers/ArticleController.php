<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\ArticleRequest;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::all();
        return view('articles.index', compact('articles'));
    }

    public function create()
    {
        $users = User::all();
        return view('articles.create', compact('users')); 
    }

    public function store(ArticleRequest $request)
    {
        $validated = $request->validated();

        // Vérifie si un article identique existe déjà
        $articleExistant = Article::where('codearticle', $validated['codearticle'])
                                  ->where('libelle', $validated['libelle'])
                                  ->where('lot', $validated['lot'])
                                  ->first();

        if ($articleExistant) {
            // Mise à jour manuelle de la quantité
            $nouvelleQuantite = $articleExistant->quantitestock + $validated['quantitestock'];
            $articleExistant->update(['quantitestock' => $nouvelleQuantite]);

            return redirect()->route('articles.index')
                ->with('success', 'L’article existait déjà. Sa quantité a été augmentée.');
        } else {
            // Création d’un nouveau article
            Article::create($validated);

            return redirect()->route('articles.index')
                ->with('success', 'Article ajouté avec succès.');
        }
    }

    public function show(Article $article)
    {
        return view('articles.show', compact('article'));
    }

    public function edit(Article $article)
    {
        $users = User::all();
        return view('articles.edit', compact('article', 'users'));
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

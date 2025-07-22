<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\MouvementArticle;
use App\Http\Requests\MouvementRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MouvementArticleController extends Controller
{
    public function index()
    {
        return redirect()->route('mouvements_articles.create');
    }

    public function create(Request $request)
    {
        $articles = Article::all();
        $articleSelectionne = $request->query('article'); // ex: article=123

        if ($articleSelectionne) {
            $mouvements = MouvementArticle::where('article_id', $articleSelectionne)->latest()->get();
        } else {
            $mouvements = MouvementArticle::latest()->get();
        }

        return view('mouvements_articles.create', compact('articles', 'articleSelectionne', 'mouvements'));
    }

    public function store(MouvementRequest $request)
    {
        $data = $request->validated();
        $article = Article::findOrFail($data['article_id']);

        $entree = $data['quantite_entree'] ?? 0;
        $sortie = $data['quantite_sortie'] ?? 0;
        $avarie = $data['avarie'] ?? 0;

        $article->quantitestock += $entree - $sortie;
        $article->save();

        $stockJour = $article->quantitestock - $avarie;

        MouvementArticle::create([
            'article_id'         => $article->id,
            'date'               => Carbon::now()->toDateString(),
            'origine'            => $data['origine'] ?? null,
            'quantite_commandee' => $data['quantite_commandee'],
            'quantite_entree'    => $entree ?: null,
            'quantite_sortie'    => $sortie ?: null,
            'stock_debut_mois'   => $data['stock_debut_mois'],
            'avarie'             => $avarie ?: null,
            'stock_jour'         => $stockJour,
            'observation'        => $data['observation'] ?? null,
        ]);

        return redirect()->route('mouvements_articles.create', ['article' => $article->id]);
    }

    public function edit(MouvementArticle $mouvement)
    {
        $articles = Article::all();
        return view('mouvements_articles.edit', compact('mouvement', 'articles'));
    }

    public function update(MouvementRequest $request, MouvementArticle $mouvement)
    {
        $data = $request->validated();
        $article = $mouvement->article;

        $ancienImpact = ($mouvement->quantite_entree ?? 0) - ($mouvement->quantite_sortie ?? 0);
        $article->quantitestock -= $ancienImpact;

        $newEntree = $data['quantite_entree'] ?? 0;
        $newSortie = $data['quantite_sortie'] ?? 0;
        $newImpact = $newEntree - $newSortie;
        $article->quantitestock += $newImpact;
        $article->save();

        $avarie = $data['avarie'] ?? 0;
        $stockJour = $article->quantitestock - $avarie;

        $mouvement->update([
            'date'               => Carbon::now()->toDateString(),
            'origine'            => $data['origine'] ?? null,
            'quantite_commandee' => $data['quantite_commandee'],
            'quantite_entree'    => $newEntree ?: null,
            'quantite_sortie'    => $newSortie ?: null,
            'stock_debut_mois'   => $data['stock_debut_mois'],
            'avarie'             => $avarie ?: null,
            'stock_jour'         => $stockJour,
            'observation'        => $data['observation'] ?? null,
        ]);

        return redirect()->route('mouvements_articles.create', ['article' => $article->id]);
    }

    public function destroy(MouvementArticle $mouvement)
    {
        $article = $mouvement->article;
        $impact  = ($mouvement->quantite_entree ?? 0) - ($mouvement->quantite_sortie ?? 0);
        $article->quantitestock -= $impact;
        $article->save();

        $mouvement->delete();
        return redirect()->route('mouvements_articles.create', ['article' => $article->id]);
    }

    public function filterByArticle($article_id)
    {
        return redirect()->route('mouvements_articles.create', ['article' => $article_id]);
    }
}

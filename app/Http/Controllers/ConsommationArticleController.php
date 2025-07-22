<?php

namespace App\Http\Controllers;

use App\Models\ConsommationArticle;
use App\Models\Article;
use App\Models\MouvementArticle;
use Illuminate\Http\Request;
use App\Http\Requests\ConsommationRequest;

class ConsommationArticleController extends Controller
{
    public function index()
    {
        return redirect()->route('consommations_articles.create');
    }

    public function create(Request $request)
    {
        $articles = Article::all();
        $article_id = $request->query('article_id');
        $annee = $request->query('annee') ?? date('Y');

        $consommations_mensuelles = array_fill(1, 12, 0);

        if ($article_id) {
            $mensuelles = MouvementArticle::selectRaw("
                    CAST(strftime('%m', date) AS INTEGER)  AS mois,
                    COALESCE(SUM(quantite_sortie),0)      AS total")
                ->where('article_id', $article_id)
                ->whereYear('date', $annee)           
                ->where('quantite_sortie', '>', 0)
                ->groupByRaw("CAST(strftime('%m', date) AS INTEGER)")
                ->pluck('total', 'mois');

            foreach ($mensuelles as $mois => $total) {
                $consommations_mensuelles[$mois] = $total;
            }
        }

        $consommations = ConsommationArticle::with('article')
                          ->orderBy('annee', 'desc')
                          ->get();

        return view('consommations_articles.create', compact(
            'articles',
            'consommations',
            'article_id',
            'annee',
            'consommations_mensuelles'
        ));
    }

    public function store(ConsommationRequest $request)
    {
        $data = $request->validated();
        ConsommationArticle::create($data);

        ConsommationArticle::recalcForArticleYear($data['article_id'], $data['annee']);

        return redirect()->route('consommations_articles.create', [
            'article_id' => $data['article_id'],
            'annee' => $data['annee']
        ]);
    }

    public function edit(ConsommationArticle $consommation)
    {
        $articles = Article::all();
        return view('consommations_articles.edit', compact('consommation', 'articles'));
    }

    public function update(ConsommationRequest $request, ConsommationArticle $consommation)
    {
        $data = $request->validated();
        $consommation->update($data);

        ConsommationArticle::recalcForArticleYear($data['article_id'], $data['annee']);

        return redirect()->route('consommations_articles.create', [
            'article_id' => $data['article_id'],
            'annee' => $data['annee']
        ]);
    }

    public function destroy(ConsommationArticle $consommation)
    {
        $article_id = $consommation->article_id;
        $annee = $consommation->annee;

        $consommation->delete();

        ConsommationArticle::recalcForArticleYear($article_id, $annee);

        return redirect()->route('consommations_articles.create', [
            'article_id' => $article_id,
            'annee' => $annee
        ]);
    }
}

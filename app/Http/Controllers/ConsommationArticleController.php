<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\MouvementArticle;
use Illuminate\Http\Request;
use App\Http\Requests\ConsommationArticleRequest;
use App\Models\ConsommationArticle;


class ConsommationArticleController extends Controller
{
    public function index()
    {
        return redirect()->route('consommations-articles.create');
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

        return view('consommations-articles.create', compact(
            'articles',
            'consommations',
            'article_id',
            'annee',
            'consommations_mensuelles'
        ));
    }

    public function store(ConsommationArticleRequest $request)
    {
        $data = $request->validated();
        ConsommationArticle::create($data);

        ConsommationArticle::recalcForArticleYear($data['article_id'], $data['annee']);

        return redirect()->route('consommations-articles.create', [
            'article_id' => $data['article_id'],
            'annee' => $data['annee']

            ])->with('success', 'Consommation créée avec succès.');

                
       

        
    }

    public function edit(ConsommationArticle $consommation_article)
    {
        $articles = Article::all();
        return view('consommations-articles.edit', [
            'consommation' => $consommation_article,
            'articles' => $articles
        ]);
            
    }

    public function update(ConsommationArticleRequest $request, ConsommationArticle $consommation_article)
    {
        $data = $request->validated();
        $consommation_article->update($data);

        ConsommationArticle::recalcForArticleYear($data['article_id'], $data['annee']);

        return redirect()->route('consommations-articles.create', [
            'article_id' => $data['article_id'],
            'annee' => $data['annee']

            ])->with('success', 'Consommation mise à jour avec succès.');

    }

    public function destroy(ConsommationArticle $consommation_article)
    {
        $article_id = $consommation_article->article_id;
        $annee = $consommation_article->annee;

        // recalculer d'abord si la suppression ne change pas les données nécessaires
        //ConsommationArticle::recalcForArticleYear($article_id, $annee);

        $consommation_article->delete();

        return redirect()->route('consommations-articles.create', [
            'article_id' => $article_id,
            'annee' => $annee
            
            ])->with('success', 'Consommation supprimée avec succès.');

        
    }

}

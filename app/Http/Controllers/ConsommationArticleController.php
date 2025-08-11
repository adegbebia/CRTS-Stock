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
        $user = auth()->user();
        if (!($user->hasRole('magasinier_collation') && $user->magasin_affecte === 'collation')) {
            return redirect()->route('dashboard')->with('error', 'Accès refusé.');
        }
        return redirect()->route('consommations-articles.create');
    }

    public function create(Request $request)
{
    $user = auth()->user();

    if (!($user->hasRole('magasinier_collation') && $user->magasin_affecte === 'collation')) {
        return redirect()->route('articles.index')->with('error', 'Vous n\'êtes pas autorisé à accéder à cette page.');
    }

    $articles = Article::all();
    $article_id = $request->query('article_id');
    $annee = $request->query('annee', date('Y'));
    $search = $request->query('search');
    $consommations_mensuelles = array_fill(1, 12, 0);

    // Requête principale pour les consommations, ordonnée par année décroissante
    $consommationsQuery = ConsommationArticle::with('article')->orderBy('annee', 'desc');

    // Filtrage par libellé (style article)
    if (!empty($search)) {
        $articleIds = Article::where('libelle', 'like', '%' . $search . '%')->pluck('article_id');
        $consommationsQuery->whereIn('article_id', $articleIds);
    }

    $consommations = $consommationsQuery->paginate(2);

    // Si un article est sélectionné, on calcule les consommations mensuelles
    if (!empty($article_id)) {
        $resultats = MouvementArticle::selectRaw("CAST(strftime('%m', date) AS INTEGER) AS mois, SUM(quantite_sortie) AS total")
            ->where('article_id', $article_id)
            ->whereYear('date', $annee)
            ->where('quantite_sortie', '>', 0)
            ->groupByRaw("CAST(strftime('%m', date) AS INTEGER)")
            ->get();

        foreach ($resultats as $resultat) {
            $mois = $resultat->mois;
            $total = $resultat->total;
            $consommations_mensuelles[$mois] = $total;
        }
    }

    return view('consommations-articles.create', compact(
        'articles',
        'consommations',
        'article_id',
        'annee',
        'consommations_mensuelles',
        'search'
    ));
}



    public function store(ConsommationArticleRequest $request)
    {
        $user = auth()->user();
        if (!($user->hasRole('magasinier_collation') && $user->magasin_affecte === 'collation')) {
            return redirect()->route('consommations-articles.create')->with('error', 'Accès refusé.');
        }
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
        $user = auth()->user();
        if (!($user->hasRole('magasinier_collation') && $user->magasin_affecte === 'collation')) {
            return redirect()->route('consommations-articles.create')->with('error', 'Accès refusé.');
        }
        $articles = Article::all();
        return view('consommations-articles.edit', [
            'consommation' => $consommation_article,
            'articles' => $articles
        ]);
            
    }

    public function update(ConsommationArticleRequest $request, ConsommationArticle $consommation_article)
    {
        $user = auth()->user();
        if (!($user->hasRole('magasinier_collation') && $user->magasin_affecte === 'collation')) {
            return redirect()->route('consommations-articles.create')->with('error', 'Accès refusé.');
        }
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
        $user = auth()->user();
        if (!($user->hasRole('magasinier_collation') && $user->magasin_affecte === 'collation')) {
            return redirect()->route('consommations-articles.create')->with('error', 'Accès refusé.');
        }
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

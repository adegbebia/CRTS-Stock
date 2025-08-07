<?php

namespace App\Http\Controllers;

use App\Models\ConsommationArticle;
use App\Models\Article;
use App\Models\MouvementArticle;
use App\Http\Requests\MouvementArticleRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MouvementArticleController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        if (!($user->hasRole(['magasinier_collation','admin']) && $user->magasin_affecte !== 'admin' || $user->magasin_affecte !== 'collation')) {
            return redirect()->route('articles.index')->with('error', 'Vous n\'êtes pas autorisé à accéder à cette page.');
        }
        return redirect()->route('mouvements-articles.create');
    }

    public function create(Request $request)
    {
        $user = auth()->user();

        if (!($user->hasRole('magasinier_collation') && $user->magasin_affecte === 'collation')) {
            return redirect()->route('articles.index')->with('error', 'Vous n\'êtes pas autorisé à accéder à cette page.');
        }

        $articles = Article::all();
        $articleSelectionne = $request->query('article');
        $date = $request->query('date');

        // Construction de la requête
        $query = MouvementArticle::with('article')->latest();

        if ($articleSelectionne) {
            $query->where('article_id', $articleSelectionne);
        }

        if ($date) {
            $query->whereDate('date', $date);
        }

        $mouvements = $query->paginate(10);

        return view('mouvements-articles.create', compact('articles', 'articleSelectionne', 'date', 'mouvements'));
    }


    public function store(MouvementArticleRequest $request)
    {

        $user = auth()->user();

        if (!($user->hasRole('magasinier_collation') && $user->magasin_affecte === 'collation')) {
            return redirect()->route('articles.index')->with('error', 'Vous n\'êtes pas autorisé à accéder à cette page.');
        }
        $data = $request->validated();
        $article = Article::findOrFail($data['article_id']);

        $entree = $data['quantite_entree'] ?? 0;
        $sortie = $data['quantite_sortie'] ?? 0;
        $avarie = $data['avarie'] ?? 0;

        if ($sortie > $article->quantitestock) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Quantité en stock insuffisante pour cette sortie. Stock disponible : ' . $article->quantitestock);
        }

        $article->quantitestock += $entree - $sortie;
        $article->save();

        $stockJour = $article->quantitestock - $avarie;

        MouvementArticle::create([
            'article_id'         => $article->article_id,
            'date'               => Carbon::now()->toDateString(),
            'origine'            => $data['origine'] ?? null,
            'quantite_commandee' => $data['quantite_commandee']?? null,
            'quantite_entree'    => $entree ?: null,
            'quantite_sortie'    => $sortie ?: null,
            // 'stock_debut_mois'   => $data['stock_debut_mois'],
            'avarie'             => $avarie ?: null,
            'stock_jour'         => $stockJour,
            'observation'        => $data['observation'] ?? null,
        ]);

    return redirect()
        ->route('mouvements-articles.create', ['article' => $article->article_id])
        ->with('success', 'Mouvement créé avec succès.');
        }

    public function edit(MouvementArticle $mouvements_article)
    {

        $user = auth()->user();

        if (!($user->hasRole('magasinier_collation') && $user->magasin_affecte === 'collation')) {
            return redirect()->route('articles.index')->with('error', 'Vous n\'êtes pas autorisé à accéder à cette page.');
        }
        $articles = Article::all();
        return view('mouvements-articles.edit', [
            'mouvement' => $mouvements_article,
            'articles' => $articles
        ]);
    }

    public function update(MouvementArticleRequest $request, MouvementArticle $mouvements_article)
    {
        $user = auth()->user();

        if (!($user->hasRole('magasinier_collation') && $user->magasin_affecte === 'collation')) {
            return redirect()->route('articles.index')->with('error', 'Vous n\'êtes pas autorisé à accéder à cette page.');
        }
        $data = $request->validated();
        $article = $mouvements_article->article;

        $ancienImpact = ($mouvements_article->quantite_entree ?? 0) - ($mouvements_article->quantite_sortie ?? 0);
        $article->quantitestock -= $ancienImpact;

        $newEntree = $data['quantite_entree'] ?? 0;
        $newSortie = $data['quantite_sortie'] ?? 0;
        $newImpact = $newEntree - $newSortie;
        $article->quantitestock += $newImpact;
        $article->save();

        // Vérification du stock disponible
    if ($newSortie > $article->quantitestock + $ancienImpact) {
        return redirect()->back()
                         ->withInput()
                         ->with('error', 'Quantité en stock insuffisante pour cette sortie. Stock disponible : ' . ($article->quantitestock + $ancienImpact));
    }

        $avarie = $data['avarie'] ?? 0;
        $stockJour = $article->quantitestock - $avarie;

        $mouvements_article->update([
            'date'               => Carbon::now()->toDateString(),
            'origine'            => $data['origine'] ?? null,
            'quantite_commandee' => $data['quantite_commandee']?? null,
            'quantite_entree'    => $newEntree ?: null,
            'quantite_sortie'    => $newSortie ?: null,
            // 'stock_debut_mois'   => $data['stock_debut_mois'],
            'avarie'             => $avarie ?: null,
            'stock_jour'         => $stockJour,
            'observation'        => $data['observation'] ?? null,
        ]);

        return redirect()->route('mouvements-articles.create', ['article' => $article->article_id])
                 ->with('success', 'Mouvement mis à jour avec succès.');

    }

    public function destroy(MouvementArticle $mouvements_article)
    {
        $user = auth()->user();

        if (!($user->hasRole('magasinier_collation') && $user->magasin_affecte === 'collation')) {
            return redirect()->route('articles.index')->with('error', 'Vous n\'êtes pas autorisé à accéder à cette page.');
        }
        $article = $mouvements_article->article;
        $impact  = ($mouvements_article->quantite_entree ?? 0) - ($mouvements_article->quantite_sortie ?? 0);
        $article->quantitestock -= $impact;
        $article->save();

        $mouvements_article->delete();
        return redirect()->route('mouvements-articles.create', ['article' => $article->article_id]);
    }

    public function filterByArticle($article_id)
    {
        return redirect()->route('mouvements-articles.create', ['article' => $article_id]);
    }
}

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

        if (!($user->hasRole(['magasinier_collation', 'admin']))) {
            return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à effectuer cette action.');
        }

        $search = strtolower($request->input('search', ''));
        $paginates = 2;
        $query = Article::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(codearticle) LIKE ?', ["%$search%"])
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

        $articles = $query->paginate($paginates);
        $users = User::all();

        return view('articles.index', compact('articles','users'));
    }

    public function create()
    {
        $user = auth()->user();

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
        $validated['codearticle'] = strtoupper($validated['codearticle']);
        $validated['libelle'] = ucfirst(strtolower($validated['libelle']));
        $validated['dateperemption'] = $request->input('dateperemption');
        $validated['lot'] = $request->input('lot');

        $articleAvecCode = Article::where('codearticle', $validated['codearticle'])->first();
        if ($articleAvecCode && $articleAvecCode->libelle !== $validated['libelle']) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['codearticle' => 'Ce code article est déjà utilisé pour un autre libellé.']);
        }

        $articleExistant = Article::where('libelle', $validated['libelle'])
            ->where('conditionnement', $validated['conditionnement'])
            ->first();

        if ($articleExistant) {
            $articleExistant->quantitestock += $validated['quantitestock'];
            $articleExistant->stockmax = $validated['stockmax'] ?? $articleExistant->stockmax;
            $articleExistant->stockmin = $validated['stockmin'] ?? $articleExistant->stockmin;
            $articleExistant->stocksecurite = $validated['stocksecurite'] ?? $articleExistant->stocksecurite;
            $articleExistant->dateperemption = $validated['dateperemption'];
            $articleExistant->lot = $validated['lot'];
            $articleExistant->save();

            return redirect()->route('articles.index')
                ->with('success', 'Article déjà existant. Stock et informations mis à jour.');
        }

        $validated['date'] = Carbon::now()->toDateString();
        Article::create($validated);

        return redirect()->route('articles.index')
            ->with('success', 'Article ajouté avec succès.');
    }

    public function edit(Article $article)
    {
        $user = auth()->user();

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
        $validated['codearticle'] = strtoupper($validated['codearticle']);
        $validated['libelle'] = ucfirst(strtolower($validated['libelle']));
        $validated['dateperemption'] = $request->input('dateperemption');
        $validated['lot'] = $request->input('lot');

        $articleAvecCode = Article::where('codearticle', $validated['codearticle'])
            ->where('article_id', '!=', $article->article_id)
            ->first();

        if ($articleAvecCode && $articleAvecCode->libelle !== $validated['libelle']) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['codearticle' => 'Ce code article est déjà utilisé pour un autre libellé.']);
        }

        $articleExistant = Article::where('libelle', $validated['libelle'])
            ->where('conditionnement', $validated['conditionnement'])
            ->where('article_id', '!=', $article->article_id)
            ->first();

        if ($articleExistant) {
            $articleExistant->quantitestock += $validated['quantitestock'];
            $articleExistant->stockmax = $validated['stockmax'] ?? $articleExistant->stockmax;
            $articleExistant->stockmin = $validated['stockmin'] ?? $articleExistant->stockmin;
            $articleExistant->stocksecurite = $validated['stocksecurite'] ?? $articleExistant->stocksecurite;
            $articleExistant->dateperemption = $validated['dateperemption'];
            $articleExistant->lot = $validated['lot'];
            $articleExistant->save();

            $article->delete();

            return redirect()->route('articles.index')
                ->with('success', 'Article fusionné et mis à jour.');
        }

        $article->update($validated);

        return redirect()->route('articles.index')->with('success', 'Article mis à jour avec succès.');
    }
}

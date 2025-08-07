<?php

namespace App\Observers;

use App\Models\Article;
use App\Models\AlerteArticle;
use Carbon\Carbon;

class ArticleObserver
{
    /**
     * Handle the Alerte "created" event.
     */
    public function created(Article $article): void
    {
        // Optionnel : déclencher alertes lors de la création si nécessaire
    }

    /**
     * Handle the Alerte "updated" event.
     */
    public function updated(Article $article): void
    {
        // Vérifier si la quantité ou la date de péremption a changé
        if ($article->wasChanged('quantitestock') || $article->wasChanged('dateperemption')) {
            $stock = $article->quantitestock;
            $stockSecu = $article->stocksecurite;
            $stockMin = $article->stockmin;
            $stockMax = $article->stockmax;
            $datePeremption = Carbon::parse($article->dateperemption);
            $now = Carbon::now();

            // Supprimer les alertes existantes de cet article
            AlerteArticle::where('article_id', $article->article_id)->delete();

            // Alerte produit périmé (date de péremption avant aujourd'hui)
            if ($datePeremption->lt($now)) {
                AlerteArticle::create([
                    'article_id' => $article->article_id,
                    'typealerte' => 'Article périmé',
                ]);
            }

            // Alertes selon le stock (en respectant l'ordre et logique)
            if ($stock <= 0) {
                AlerteArticle::create([
                    'article_id' => $article->article_id,
                    'typealerte' => 'Rupture de stock',
                ]);
            } elseif ($stock <= $stockSecu) {
                AlerteArticle::create([
                    'article_id' => $article->article_id,
                    'typealerte' => 'Alerte rouge',
                ]);
            } elseif ($stock <= $stockMin) {
               AlerteArticle::create([
                    'article_id' => $article->article_id,
                    'typealerte' => 'Alerte orange',
                ]);
            } elseif ($stock > $stockMin && $stock <= $stockMax) {
                AlerteArticle::create([
                    'article_id' => $article->article_id,
                    'typealerte' => 'Alerte verte',
                ]);
            } else {
                // Stock supérieur au stockmax => pas d'alerte
            }
        }
    }

    /**
     * Handle the Article "deleted" event.
     */
    public function deleted(Article $article): void
    {
        // Supprimer les alertes liées au produit supprimé
       AlerteArticle::where('article_id', $article->article_id)->delete();
    }

    /**
     * Handle the Article "restored" event.
     */
    public function restored(Article $article): void
    {
        // Recalculer les alertes lors de la restauration si nécessaire
        $this->updated($article);
    }

    /**
     * Handle the Article "force deleted" event.
     */
    public function forceDeleted(Article $article): void
    {
        // Même action que deleted
        $this->deleted($article);
    }
}
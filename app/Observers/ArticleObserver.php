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
        if ($article->wasChanged('quantitestock') || $article->wasChanged('dateperemption')) {
            $stock = $article->quantitestock;
            $stockSecu = $article->stocksecurite;
            $stockMin = $article->stockmin;
            $stockMax = $article->stockmax;

            // Supprimer les anciennes alertes
            AlerteArticle::where('article_id', $article->article_id)->delete();

            // Alerte produit périmé (si la date existe ET est passée)
            if (!empty($article->dateperemption)) {
                $datePeremption = Carbon::parse($article->dateperemption);
                if ($datePeremption->lt(now())) {
                    AlerteArticle::create([
                        'article_id' => $article->article_id,
                        'typealerte' => 'Article périmé',
                    ]);
                }
            }

            // Alertes de stock
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
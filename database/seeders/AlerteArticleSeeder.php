<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\AlerteArticle;

class AlerteArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // $article1=Article::where('codearticle','C001')->first();
        // $article2=Article::where('codearticle','C002')->first();
        // $article3=Article::where('codearticle','C003')->first();


        // AlerteArticle::create([
        //     'article_id' => $article1->article_id,  // Barre énergétique
        //     'typealerte' => 'Alerte rouge',
        // ]);

        // AlerteArticle::create([
        //     'article_id' => $article2->article_id,  // Jus de fruits
        //     'typealerte' => 'Alerte orange',
        // ]);

        // AlerteArticle::create([
        //     'article_id' => $article3->article_id,  // Biscuits salés
        //     'typealerte' => 'Produit périmé',
        // ]);
    }
}

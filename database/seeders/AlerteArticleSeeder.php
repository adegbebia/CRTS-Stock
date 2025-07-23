<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AlerteArticle;

class AlerteArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AlerteArticle::create([
            'article_id' => 1,  // Barre énergétique
            'typealerte' => 'rouge',
        ]);

        AlerteArticle::create([
            'article_id' => 2,  // Jus de fruits
            'typealerte' => 'orange',
        ]);

        AlerteArticle::create([
            'article_id' => 3,  // Biscuits salés
            'typealerte' => 'perime',
        ]);
    }
}

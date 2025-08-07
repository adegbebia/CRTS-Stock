<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MouvementArticle;


class MouvementArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        MouvementArticle::create([
            'article_id'         => 1,
            'date'               => '2025-07-10',
            'origine'            => 'Commande Fournisseur',
            'quantite_commandee' => 500,
            'quantite_entree'    => 500,
            'quantite_sortie'    => null,
            // 'stock_debut_mois'   => 200,
            'avarie'             => 0,
            'stock_jour'         => 700,
            'observation'        => 'Réception complète',
        ]);

        MouvementArticle::create([
            'article_id'         => 1,
            'date'               => '2025-07-12',
            'origine'            => 'Service de collation',
            'quantite_commandee' => 0,
            'quantite_entree'    => null,
            'quantite_sortie'    => 120,
            // 'stock_debut_mois'   => 700,
            'avarie'             => 0,
            'stock_jour'         => 580,
            'observation'        => 'Sortie normale',
        ]);

        MouvementArticle::create([
            'article_id'         => 2,
            'date'               => '2025-07-14',
            'origine'            => 'Contrôle qualité',
            'quantite_commandee' => 0,
            'quantite_entree'    => null,
            'quantite_sortie'    => null,
            // 'stock_debut_mois'   => 1000,
            'avarie'             => 50,
            'stock_jour'         => 950,
            'observation'        => 'Avarie détectée',
        ]);
    }
}

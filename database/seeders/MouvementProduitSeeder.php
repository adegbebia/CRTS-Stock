<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MouvementProduit;
use Carbon\Carbon;

class MouvementProduitSeeder extends Seeder
{
    public function run(): void
    {
        MouvementProduit::create([
            'produit_id'         => 1,
            'date'               => '2025-07-10',
            'origine'            => 'Commande Fournisseur',
            'quantite_commandee' => 500,
            'quantite_entree'    => 500,
            'quantite_sortie'    => null,
            'stock_debut_mois'   => 200,
            'avarie'             => 0,
            'stock_jour'         => 700,
            'observation'        => 'Réception complète',
        ]);

        MouvementProduit::create([
            'produit_id'         => 1,
            'date'               => '2025-07-12',
            'origine'            => 'Service de chirurgie',
            'quantite_commandee' => 0,
            'quantite_entree'    => null,
            'quantite_sortie'    => 120,
            'stock_debut_mois'   => 700,
            'avarie'             => 0,
            'stock_jour'         => 580,
            'observation'        => 'Sortie normale',
        ]);

        MouvementProduit::create([
            'produit_id'         => 2,
            'date'               => '2025-07-14',
            'origine'            => 'Contrôle qualité',
            'quantite_commandee' => 0,
            'quantite_entree'    => null,
            'quantite_sortie'    => null,
            'stock_debut_mois'   => 1000,
            'avarie'             => 50,
            'stock_jour'         => 950,
            'observation'        => 'Avarie détectée',
        ]);
    }
}

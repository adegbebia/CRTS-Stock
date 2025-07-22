<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ConsommationProduit;
use App\Models\Produit;

class ConsommationProduitSeeder extends Seeder
{
    public function run(): void
{
    $produits = Produit::all();
    $annees = [2023, 2024, 2025];

    foreach ($produits as $produit) {
        foreach ($annees as $annee) {
            ConsommationProduit::create([
                'produit_id'      => $produit->produit_id,
                'annee'           => $annee,

                'consommation_janvier'   => rand(20, 40),
                'consommation_fevrier'   => rand(20, 40),
                'consommation_mars'      => rand(20, 40),
                'consommation_avril'     => rand(20, 40),
                'consommation_mai'       => rand(20, 40),
                'consommation_juin'      => rand(20, 40),
                'consommation_juillet'   => rand(20, 40),
                'consommation_aout'      => rand(20, 40),
                'consommation_septembre' => rand(20, 40),
                'consommation_octobre'   => rand(20, 40),
                'consommation_novembre'  => rand(20, 40),
                'consommation_decembre'  => rand(20, 40),

                'rupture_janvier'   => rand(0, 3),
                'rupture_fevrier'   => rand(0, 3),
                'rupture_mars'      => rand(0, 3),
                'rupture_avril'     => rand(0, 3),
                'rupture_mai'       => rand(0, 3),
                'rupture_juin'      => rand(0, 3),
                'rupture_juillet'   => rand(0, 3),
                'rupture_aout'      => rand(0, 3),
                'rupture_septembre' => rand(0, 3),
                'rupture_octobre'   => rand(0, 3),
                'rupture_novembre'  => rand(0, 3),
                'rupture_decembre'  => rand(0, 3),
            ]);
        }
    }
}
}
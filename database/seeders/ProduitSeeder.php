<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Produit; 
class ProduitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
    Produit::create([
        'codeproduit'     => 'P001',
        'libelle'         => 'Gants chirurgicaux',
        'conditionnement' => 'Boîte de 100',
        'quantitestock'   => 250,
        'stockmax'        => 500,
        'stockmin'        => 100,
        'stocksecurite'   => 150,
        'dateperemption'  => '2026-12-31',
        'lot'             => 'LOT2025A',
        'user_id'         => 2,
    ]);

    Produit::create([
        'codeproduit'     => 'P002',
        'libelle'         => 'Seringues 5ml',
        'conditionnement' => 'Paquet de 50',
        'quantitestock'   => 120,
        'stockmax'        => 300,
        'stockmin'        => 80,
        'stocksecurite'   => 100,
        'dateperemption'  => '2027-06-15',
        'lot'             => 'LOT2025B',
        'user_id'         => 3,
    ]);

    Produit::create([
        'codeproduit'     => 'P003',
        'libelle'         => 'Poches de sang',
        'conditionnement' => 'Unité',
        'quantitestock'   => 60,
        'stockmax'        => 150,
        'stockmin'        => 40,
        'stocksecurite'   => 50,
        'dateperemption'  => '2026-11-30',
        'lot'             => 'LOT2025C',
        'user_id'         => 1,
    ]);

    }
}

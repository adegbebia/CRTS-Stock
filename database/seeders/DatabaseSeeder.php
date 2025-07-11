<?php

namespace Database\Seeders;
use App\Models\User;
use App\Models\Produit;
use App\Models\Alerte;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {




        $this->call([
            UserSeeder::class,
            ProduitSeeder::class,
            AlerteSeeder::class,
            MouvementSeeder::class,
        ]);
        



    }
}

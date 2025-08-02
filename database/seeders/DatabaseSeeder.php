<?php

namespace Database\Seeders;
use App\Models\User;
use App\Models\Produit;
use App\Models\AlerteProduit;
use App\Models\AlerteArticle;
use App\Models\Article;


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
            RolePermissionSeeder::class,
            UserSeeder::class,
            ProduitSeeder::class,
            AlerteProduitSeeder::class,
            MouvementProduitSeeder::class,
            ConsommationProduitSeeder::class,
            ArticleSeeder::class,
            AlerteArticleSeeder::class,
            ConsommationArticleSeeder::class,
            MouvementArticleSeeder::class,

        ]);
        



    }
}

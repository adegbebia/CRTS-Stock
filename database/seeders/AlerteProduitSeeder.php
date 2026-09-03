<?php

    namespace Database\Seeders;

    use Illuminate\Database\Seeder;
    use App\Models\AlerteProduit;
    use App\Models\Produit;

    class AlerteProduitSeeder extends Seeder
    {
    public function run(): void
    {
        // $produit1 = Produit::where('codeproduit', 'P001')->first();
        // $produit2 = Produit::where('codeproduit', 'P002')->first();
        // $produit3 = Produit::where('codeproduit', 'P003')->first();

        // AlerteProduit::create([
        //     'produit_id' => $produit1->produit_id,
        //     'typealerte' => 'Alerte rouge',
        // ]);

        // AlerteProduit::create([
        //     'produit_id' => $produit2->produit_id,
        //     'typealerte' => 'Alerte orange',
        // ]);

        // AlerteProduit::create([
        //     'produit_id' => $produit3->produit_id,
        //     'typealerte' => 'Produit périmé',
        // ]);
    }

    }

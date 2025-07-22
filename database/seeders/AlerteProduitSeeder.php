<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AlerteProduit;


class AlerteProduitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //  
    AlerteProduit::create([
        'produit_id'        => 1, 
        'typealerte'        => 'rouge',
    ]);

    AlerteProduit::create([
        'produit_id'        => 2,
        'typealerte'        => 'orange',
    ]);

    AlerteProduit::create([
        'produit_id'        => 3,
        'typealerte'        => 'perime',
    ]);

    }
}

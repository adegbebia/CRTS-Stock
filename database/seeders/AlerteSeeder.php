<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Alerte;


class AlerteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //  
    Alerte::create([
        'produit_id'        => 1, 
        'typealerte'        => 'rouge',
    ]);

    Alerte::create([
        'produit_id'        => 2,
        'typealerte'        => 'orange',
    ]);

    Alerte::create([
        'produit_id'        => 3,
        'typealerte'        => 'perime',
    ]);

    }
}

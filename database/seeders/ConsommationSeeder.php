<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Consommation;
use Carbon\Carbon;

class ConsommationSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        Consommation::create([
            'produit_id'              => 1,
            'annee_consommation'      => 2024,
            'mois'                    => 'Janvier',
            'trimestre'               => 1,
            'semestre'                => 1,
            'totalAnnuel'             => 1200,
            'nombreJourRuptureStock' => 2,
            'created_at'              => $now,
            'updated_at'              => $now,
        ]);

        Consommation::create([
            'produit_id'              => 2,
            'annee_consommation'      => 2024,
            'mois'                    => 'Février',
            'trimestre'               => 1,
            'semestre'                => 1,
            'totalAnnuel'             => 850,
            'nombreJourRuptureStock' => 0,
            'created_at'              => $now,
            'updated_at'              => $now,
        ]);

        Consommation::create([
            'produit_id'              => 1,
            'annee_consommation'      => 2024,
            'mois'                    => 'Mars',
            'trimestre'               => 1,
            'semestre'                => 1,
            'totalAnnuel'             => 1100,
            'nombreJourRuptureStock' => 1,
            'created_at'              => $now,
            'updated_at'              => $now,
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        User::create([
            'nom'               => 'DEGBEBIA',
            'prenom'            => 'Aïmane',
            'adresse'            => 'Komah',
            'telephone'            => 98112012,
            'magasin_affecte' => 'technique',
            'email'             => 'aimane@gmail.com',
            'email_verified_at' => $now,
            'password'          => Hash::make('password123'),
            'remember_token'    => Str::random(10),
            'created_at'        => $now,
            'updated_at'        => $now,
        ]);

        User::create([
            'nom'               => 'BABA',
            'prenom'            => 'Traore-hannatou',
            'adresse'            => 'Didaoure',
            'telephone'            => 90909138,
            'magasin_affecte' => 'technique',
            'email'             => 'hannatou@gmail.com',
            'email_verified_at' => $now,
            'password'          => Hash::make('password123'),
            'remember_token'    => Str::random(10),
            'created_at'        => $now,
            'updated_at'        => $now,
        ]);

        User::create([
            'nom'               => 'ADOUN',
            'prenom'            => 'Hyaceinthe',
            'adresse'            => 'Bariere',
            'telephone'            => 90205203,
            'magasin_affecte' => 'technique',
            'email'             => 'Hyaceinthe@gmail.com',
            'email_verified_at' => $now,
            'password'          => Hash::make('password123'),
            'remember_token'    => Str::random(10),
            'created_at'        => $now,
            'updated_at'        => $now,
        ]);

        User::create([
            'nom'               => 'YERIMA',
            'prenom'            => 'Sadate',
            'adresse'           => 'Komah3',
            'telephone'         => 98112012,
            'magasin_affecte'   => 'collation',
            'email'             => 'sadate@gmail.com',
            'email_verified_at' => $now,
            'password'          => Hash::make('password123'),
            'remember_token'    => Str::random(10),
            'created_at'        => $now,
            'updated_at'        => $now,
        ]);

        User::create([
            'nom'               => 'KODJO',
            'prenom'            => 'Ama',
            'adresse'           => 'Koulounde',
            'telephone'         => 98112012,
            'magasin_affecte'   => 'collation',
            'email'             => 'ama@gmail.com',
            'email_verified_at' => $now,
            'password'          => Hash::make('password123'),
            'remember_token'    => Str::random(10),
            'created_at'        => $now,
            'updated_at'        => $now,
        ]);
    }
}

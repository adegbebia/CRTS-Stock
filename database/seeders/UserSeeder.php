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
            'email'             => 'Hyaceinthe@gmail.com',
            'email_verified_at' => $now,
            'password'          => Hash::make('password123'),
            'remember_token'    => Str::random(10),
            'created_at'        => $now,
            'updated_at'        => $now,
        ]);
    }
}

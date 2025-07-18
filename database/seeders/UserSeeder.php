<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();



        $user1 = User::create([
            'nom'               => 'DEGBEBIA',
            'prenom'            => 'Aïmane',
            'email'             => 'aimane@gmail.com',
            'email_verified_at' => $now,
            'password'          => Hash::make('password123'),
            'remember_token'    => Str::random(10),
            'created_at'        => $now,
            'updated_at'        => $now,
        ]);
        $user1->assignRole('directeur');


        $user2 = User::create([
            'nom'               => 'BABA',
            'prenom'            => 'Traore-hannatou',
            'email'             => 'hannatou@gmail.com',
            'email_verified_at' => $now,
            'password'          => Hash::make('password123'),
            'remember_token'    => Str::random(10),
            'created_at'        => $now,
            'updated_at'        => $now,
        ]);
        $user2->assignRole('responsable_surveillant');


        $user3 = User::create([
            'nom'               => 'ADOUN',
            'prenom'            => 'Hyaceinthe',
            'email'             => 'Hyaceinthe@gmail.com',
            'email_verified_at' => $now,
            'password'          => Hash::make('password123'),
            'remember_token'    => Str::random(10),
            'created_at'        => $now,
            'updated_at'        => $now,
        ]);
        $user3->assignRole('responsable technique');

    }
}

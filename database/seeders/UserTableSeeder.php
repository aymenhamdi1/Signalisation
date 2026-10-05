<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    // Vérifier si l'utilisateur existe déjà
    if (!User::where('email', 'admin@mehat.gov.tn')->exists()) {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@mehat.gov.tn',
            'password' => Hash::make('password'),  // Change le mot de passe si nécessaire
            'role' => 'admin',
            'status' => 'active',
            'phone' => '55407674',
            'adresse' => 'Adresse',
            'username' => 'Admin',
            'gender' => 'Male',
        ]);
    }
}
}

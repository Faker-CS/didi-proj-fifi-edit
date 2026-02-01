<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create a seeded user for quick testing (client)
        User::factory()->create([
            'name' => 'Mr Faker',
            'email' => 'mrfaker@exemple.com',
            'password' => Hash::make('faker123'),
            'role' => 'client',
        ]);

        // Create an admin seeded user
        User::factory()->create([
            'name' => 'Douroubi Admin',
            'email' => 'douroubi@exemple.com',
            'password' => Hash::make('dadouyedadou'),
            'role' => 'admin',
        ]);

        // Other seed data can go here
    }
}

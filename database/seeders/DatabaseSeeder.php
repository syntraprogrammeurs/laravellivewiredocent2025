<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Maak een admin gebruiker
        User::factory()->admin()->create();

        // Maak 50 test gebruikers
        User::factory(50)->create();
    }
}

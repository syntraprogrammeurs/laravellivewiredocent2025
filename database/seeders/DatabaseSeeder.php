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
        // Eerst de rollen aanmaken
        $this->call(RoleSeeder::class);
        
        // Dan de permissions aanmaken en toekennen
        $this->call(PermissionSeeder::class);
        
        // Dan de admin gebruiker via de UserSeeder
        $this->call(UserSeeder::class);

        // Maak 50 test gebruikers
        User::factory(50)->create();
    }
}

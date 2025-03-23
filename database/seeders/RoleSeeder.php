<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Verwijder bestaande rollen
        Role::query()->delete();

        Role::create([
            'name' => 'admin',
            'guard_name' => 'web',
            'icon' => 'shield-check'
        ]);

        Role::create([
            'name' => 'editor',
            'guard_name' => 'web',
            'icon' => 'pencil'
        ]);

        Role::create([
            'name' => 'viewer',
            'guard_name' => 'web',
            'icon' => 'eye'
        ]);

        Role::create([
            'name' => 'author',
            'guard_name' => 'web',
            'icon' => 'document'
        ]);
    }
} 
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // User management permissions
        $permissions = [
            'view users',
            'create users',
            'edit users',
            'delete users',
            'restore users',
            'force delete users',
            'assign roles',
            'remove roles',
        ];

        // Create permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Assign all permissions to admin role
        $adminRole = Role::where('name', 'admin')->first();
        $adminRole->givePermissionTo($permissions);

        // Assign view permission to editor role
        $editorRole = Role::where('name', 'editor')->first();
        $editorRole->givePermissionTo('view users');

        // Assign view permission to viewer role
        $viewerRole = Role::where('name', 'viewer')->first();
        $viewerRole->givePermissionTo('view users');
    }
} 
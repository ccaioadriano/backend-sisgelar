<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Criação de permissões
        Permission::create(['name' => 'manage all groups and permissions']);
        Permission::create(['name' => 'manage specific organ context']);
        Permission::create(['name' => 'crud equipments']);
        Permission::create(['name' => 'view reports']);
        Permission::create(['name' => 'view dashboard']);

        // Criação de papéis e atribuição de permissões
        $superAdminRole = Role::create(['name' => 'Super Admin']);
        $superAdminRole->givePermissionTo([
            'manage all groups and permissions',
            'manage specific organ context',
            'crud equipments',
            'view reports',
            'view dashboard',
        ]);

        $adminRole = Role::create(['name' => 'Admin Org']);
        $adminRole->givePermissionTo([
            'manage specific organ context',
            'crud equipments',
            'view reports',
            'view dashboard',
        ]);

        $userRole = Role::create(['name' => 'User']);
        $userRole->givePermissionTo([
            'crud equipments',
            'view reports',
            'view dashboard',
        ]);

        // Criação de usuários e atribuição de papéis
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@admin.com',
            'password' => Hash::make('superadmin123'),
        ]);
        $superAdmin->assignRole($superAdminRole);

        $adminOrg = User::create([
            'name' => 'Admin Org',
            'email' => 'adminorg@org.com',
            'password' => Hash::make('adminorg123'),
        ]);
        $adminOrg->assignRole($adminRole);

        $user = User::create([
            'name' => 'User',
            'email' => 'user@user.com',
            'password' => Hash::make('user123'),
        ]);
        $user->assignRole($userRole);

        $this->call(EquipmentSeeder::class);
    }
}

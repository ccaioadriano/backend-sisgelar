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
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('123'),
        ]);

        User::create([
            'name' => 'user',
            'email' => 'user@default.com',
            'password' => Hash::make('1234'),
        ]);

        //criando grupo admin e adicionando em um usuario
        $role = Role::create(['name' => 'admin']);

        Permission::create(['name' => 'crud']);

        $role->givePermissionTo('crud');

        $admin->assignRole(['admin']);
    }
}

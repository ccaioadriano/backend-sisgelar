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
    public function generateRolesAndPermissions()
    {
        // Lista de permissões gerais
        $permissions = [
            // Permissões de gerenciamento de grupos e usuários
            'manage_all_groups', 'manage_all_permissions',
            'manage_organization', 'assign_permissions',

            // Permissões de gestão de equipamentos
            'view_equipment', 'create_equipment', 'edit_equipment', 'delete_equipment',
        ];

        // Perfis de usuários e suas permissões específicas
        $roles = [
            'super_admin' => [
                'manage_all_groups', 'manage_all_permissions',
                'manage_organization', 'assign_permissions',
                'view_equipment', 'create_equipment', 'edit_equipment', 'delete_equipment',
            ],
            'organization_admin' => [
                'manage_organization', 'assign_permissions',
                'view_equipment', 'create_equipment', 'edit_equipment', 'delete_equipment',
            ],
            'equipment_manager' => [
                'view_equipment', 'create_equipment', 'edit_equipment', 'delete_equipment',
            ],
        ];

        // Criação das permissões
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Criação das roles e associação de permissões
        foreach ($roles as $roleName => $rolePermissions) {
            $role = Role::create(['name' => $roleName]);
            foreach ($rolePermissions as $permissionName) {
                $permission = Permission::where('name', $permissionName)->first();
                $role->givePermissionTo($permission);
            }
        }
    }

    public function createUser($userName, $roleName)
    {
        $user = User::create([
            'name' => $userName,
            'email' => $userName . '@sisgelar.com',
            'password' => Hash::make('123'),
        ]);

        // Associa o usuário à role
        $role = Role::where('name', $roleName)->first();
        $user->assignRole($role);

        return $user;
    }

    public function run(): void
    {
        // Criação de usuários com roles
        $this->generateRolesAndPermissions();
        $this->createUser('super_admin_user', 'super_admin');
        $this->createUser('org_admin', 'organization_admin');
        $this->createUser('equipment_manager', 'equipment_manager');



        $this->call([BranchSeeder::class,]);
    }
}

<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class EquipmentControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $manager;

    protected function setUp(): void
    {
        parent::setUp();

        // Certifique-se de que o banco de dados de teste esteja migrado
        $this->artisan('migrate');

        // Gerar roles e permissões
        $this->generateRolesAndPermissions();

        // Criar um usuário manager
        $this->manager = User::factory()->create([
            'name' => 'manager',
            'email' => 'manager@sisgelar.com',
            'password' => Hash::make('123'),
        ]);
        $this->manager->assignRole('manager');
    }

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
            'org_admin' => [
                'manage_organization', 'assign_permissions',
                'view_equipment', 'create_equipment', 'edit_equipment', 'delete_equipment',
            ],
            'manager' => [
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
    public function can_be_created()
    {
    }
}

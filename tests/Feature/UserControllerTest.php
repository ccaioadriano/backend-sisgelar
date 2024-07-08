<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class UserControllerTest extends TestCase
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

    public function test_user_cant_be_created()
    {
        $this->actingAs($this->manager, 'api');

        $response = $this->postJson('api/admin/users', [
            'name' => 'usuario de teste',
            'email' => 'teste@example.com',
            'password' => '123',
        ]);

        $response->assertStatus(403);
    }

    public function test_user_cant_be_shown()
    {
        $this->actingAs($this->manager, 'api');

        $response = $this->getJson('api/admin/users');

        $response->assertStatus(403);
    }

    public function test_user_cant_be_updated()
    {
        $this->actingAs($this->manager, 'api');

        $user = User::factory()->create();

        $response = $this->putJson("api/admin/users/{$user->id}", [
            'name' => 'Jane Doe',
        ]);

        $response->assertStatus(403);
    }

    public function test_user_cant_be_deleted()
    {
        $this->actingAs($this->manager, 'api');

        $user = User::factory()->create();

        $response = $this->deleteJson("api/admin/users/{$user->id}");

        $response->assertStatus(403);
    }
}

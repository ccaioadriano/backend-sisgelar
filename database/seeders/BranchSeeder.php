<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Criar filiais
        $branchA = Branch::create([
            'name' => 'Filial A',
            'contact' => '123456789',
            'address' => 'Rua Principal, 123',
            'email' => 'filiala@example.com',
            'description' => 'Descrição da Filial A',
        ]);

        $branchB = Branch::create([
            'name' => 'Filial B',
            'contact' => '987654321',
            'address' => 'Avenida Central, 456',
            'email' => 'filialb@example.com',
            'description' => 'Descrição da Filial B',
        ]);

        // Criar equipamentos para filiais
        $branchA->equipments()->createMany([
            [
                'type' => 'Ar Condicionado',
                'brand' => 'Marca X',
                'client' => 'Cliente A',
                'disabled' => false,
            ],
            [
                'type' => 'Geladeira Comercial',
                'brand' => 'Marca Y',
                'client' => 'Cliente B',
                'disabled' => true,
            ],
        ]);

        $branchB->equipments()->create([
            'type' => 'Câmera Frigorífica',
            'brand' => 'Marca Z',
            'client' => 'Cliente C',
            'disabled' => false,
        ]);

        // Criar usuários associados às filiais
        User::factory()->create([
            'name' => 'Admin Filial A',
            'email' => 'admin_filiala@example.com',
            'password' => bcrypt('123'),
            'branch_id' => $branchA->id,
        ]);

        User::factory()->create([
            'name' => 'Admin Filial B',
            'email' => 'admin_filialb@example.com',
            'password' => bcrypt('123'),
            'branch_id' => $branchB->id,
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Equipment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EquipmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Equipment::create([
            'type' => 'Refrigerador',
            'brand' => 'Samsung',
            'client' => 'Cliente A',
            'disabled' => false,
        ]);

        Equipment::create([
            'type' => 'Ar Condicionado',
            'brand' => 'LG',
            'client' => 'Cliente B',
            'disabled' => true,
        ]);

        Equipment::create([
            'type' => 'Freezer',
            'brand' => 'Electrolux',
            'client' => 'Cliente C',
            'disabled' => false,
        ]);

        Equipment::create([
            'type' => 'Refrigerador',
            'brand' => 'Brastemp',
            'client' => 'Cliente D',
            'disabled' => true,
        ]);
    }
}

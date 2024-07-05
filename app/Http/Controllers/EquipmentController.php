<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Equipment;
use App\Models\User;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    public function index(Branch $branch)
    {
        // Retorna todos os equipamentos da filial especificada
        $equipments = $branch->equipments()->paginate(columns: [
            "type",
            "brand",
            "client",
            "disabled"
        ]);
        return response()->json($equipments);
    }

    public function store(Request $request, Branch $branch)
    {

        $data = $request->validate([
            'type' => 'required',
            'brand' => 'required',
            'client' => 'required',
            'disabled' => 'boolean',
        ]);

        $equipment = $branch->equipments()->create($data);

        return response()->json($equipment, 201);
    }

    public function show($id)
    {
        return Equipment::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Equipment;
use App\Models\User;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    public function index($branch_id)
    {
        // Retorna todos os equipamentos da filial especificada
        $branch = Branch::findOrFail($branch_id);
        $equipments = $branch->equipments()->paginate(columns: [
            "id",
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

    public function show($branch_id, $equipment_id)
    {
        $branch = Branch::findOrFail($branch_id);
        $equipment = $branch->equipments()->findOrFail($equipment_id);
        return response()->json($equipment);
    }

    public function update(Request $request, $branch_id, $equipment_id)
    {
        $branch = Branch::findOrFail($branch_id);
        $equipment = $branch->equipments()->findOrFail($equipment_id);

        $data = $request->validate([
            'type' => 'required',
            'brand' => 'required',
            'client' => 'required',
            'disabled' => 'boolean',
        ]);

        $equipment->update($data);

        return response()->json($equipment, 200);
    }

    public function destroy($branch_id, $equipment_id)
    {
        $branch = Branch::findOrFail($branch_id);
        $equipment = $branch->equipments()->findOrFail($equipment_id);

        $equipment->deleteOrFail();
        return response()->json($branch->equipments(), 200);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Resources\BranchResource;
use App\Http\Resources\EquipmentResource;
use App\Models\Branch;
use App\Models\Equipment;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api']);
        $this->middleware('role_or_permission:super_admin|organization_admin|equipment_manager')->except('index', 'show');
    }

    public function index()
    {
        $equipments = Equipment::all();
        return EquipmentResource::collection($equipments);
    }

    public function store(Request $request, Branch $branch)
    {
        $data = $request->validate([
            'type' => 'required|string',
            'brand' => 'required|string',
            'client' => 'required|string',
            'disabled' => 'boolean',
        ]);

        $equipment = $branch->equipments()->create($data);

        return response()->json(['message' => 'Equipment Created.', 'equipment' => $equipment], 201);
    }

    public function show($branch_id, $equipment_id)
    {
        $branch = Branch::findOrFail($branch_id);
        $equipment = $branch->equipments()->findOrFail($equipment_id);
        return new EquipmentResource($equipment);
    }

    public function update(Request $request, $branch_id, $equipment_id)
    {
        $branch = Branch::findOrFail($branch_id);
        $equipment = $branch->equipments()->findOrFail($equipment_id);

        $equipment->update($request->all());

        return response()->json([
            'message' => 'Equipment Updated.',
            'equipment' => new EquipmentResource($equipment)
        ], 200);
    }

    public function destroy($branch_id, $equipment_id)
    {
        $branch = Branch::findOrFail($branch_id);
        $equipment = $branch->equipments()->findOrFail($equipment_id);

        $equipment->deleteOrFail();
        return response()->json([
            'message' => 'Equipment Deleted.'
        ], 204);
    }
}

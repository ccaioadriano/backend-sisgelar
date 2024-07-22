<?php

namespace App\Http\Controllers;

use App\Http\Resources\EquipmentResource;
use App\Models\Branch;
use App\Models\Equipment;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api']);
        $this->middleware('role_or_permission:super_admin|organization_admin|equipment_manager')->except('index', 'show');
    }

    public function index($branch_id)
    {
        $branch = Branch::findOrFail($branch_id);
        $equipments = $branch->equipments()->paginate();
        return EquipmentResource::collection($equipments);
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

        return new EquipmentResource($equipment);
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

        $data = $request->validate([
            'type' => 'required',
            'brand' => 'required',
            'client' => 'required',
            'disabled' => 'boolean',
        ]);

        $equipment->update($data);

        return new EquipmentResource($equipment);
    }

    public function destroy($branch_id, $equipment_id)
    {
        $branch = Branch::findOrFail($branch_id);
        $equipment = $branch->equipments()->findOrFail($equipment_id);

        $equipment->deleteOrFail();
        return response()->json(null, 204);
    }
}

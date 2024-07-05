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
        $equipments = $branch->equipments()->get();
        return response()->json($equipments);
    }

    public function store(Request $request)
    {
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

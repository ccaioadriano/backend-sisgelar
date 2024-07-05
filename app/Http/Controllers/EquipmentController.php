<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    public function index()
    {
        $equipments = Equipment::all();
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

<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role_or_permission:Super Admin|Admin Org']);
    }

    public function getAllEquipments()
    {
        $equipments = Equipment::all();
        return response()->json($equipments);
    }
}

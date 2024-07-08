<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role_or_permission:super_admin|organization_admin']);
    }

    public function getAllEquipments()
    {
        $equipments = Equipment::paginate();
        return response()->json($equipments);
    }
}

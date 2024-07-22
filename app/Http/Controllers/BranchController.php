<?php

namespace App\Http\Controllers;

use App\Http\Resources\BranchResource;
use App\Models\Branch;
use App\Models\Equipment;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function __construct()
    {
        $this->middleware('role_or_permission:super_admin');
    }


    public function index()
    {

        $branches = Branch::paginate();
        return BranchResource::collection($branches);
    }

    public function show(int $branch_id)
    {
        $branch = Branch::findOrFail($branch_id);
        return new BranchResource($branch);
    }
}

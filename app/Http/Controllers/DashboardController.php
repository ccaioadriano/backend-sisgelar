<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function __construct(){
        $this->middleware(['role:super_admin']);
    }

    public function index()
    {
        return response()->json(['message' => 'Ola Super Admin!!']);
    }
}

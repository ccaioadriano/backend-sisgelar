<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function __construct(){
        $this->middleware(['role:Super Admin']);
    }

    public function index()
    {
        return response()->json(['message' => 'Ola Super Admin!!']);
    }
}

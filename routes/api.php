<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// Rotas para autenticação
Route::prefix('access')->middleware('api')->group(function () {
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('register', [AuthController::class, 'register']);
});

// Rotas para administradores
Route::prefix('admin')->middleware(['api', 'auth:api', 'role:admin'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index']);
});

// Rotas públicas acessíveis a todos os usuários autenticados
Route::middleware('auth:api')->group(function () {
    Route::get('user', function () {
        return response()->json(['message' => 'Olá usuário.']);
    });
});

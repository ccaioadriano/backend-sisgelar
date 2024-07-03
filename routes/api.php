<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::group([
    'middleware' => 'api',
    'prefix' => 'access'
], function ($router) {
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('register', [AuthController::class, 'register']);
    // Route::post('logout', [AuthController::class, 'logout']);
    // Route::post('refresh', [AuthController::class, 'refresh']);
    // Route::post('me', [AuthController::class, 'me']);
});

Route::middleware(['auth:api', 'role:admin'])->group(function () {
    // Rotas protegidas para administradores
    Route::get('admin', function () {
        return 'Area do Administrador';
    });
});

Route::middleware(['auth:api', 'role:user'])->group(function () {
    // Rotas protegidas para usuários
    Route::get('user', function () {
        return 'Area do usuario';
    });
});

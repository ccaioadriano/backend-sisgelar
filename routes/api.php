<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EquipmentController;
use Illuminate\Support\Facades\Route;

// Rotas para autenticação
Route::prefix('access')->middleware('api')->group(function () {
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('register', [AuthController::class, 'register']);
});

Route::prefix('dashboard')->middleware(['api', 'auth:api'])->group(function () {
    Route::get('/', [DashboardController::class, 'index']);
});

Route::prefix('branches')->middleware(['api', 'auth:api'])->group(function () {

    Route::get('/equipments', [BranchController::class, 'getAllEquipments']);

    Route::prefix('{branch}')->group(function () {
        Route::prefix('equipments')->group(function () {
            Route::get('/', [EquipmentController::class, 'index']);
            Route::post('/', [EquipmentController::class, 'store']);
            Route::get('{equipment}', [EquipmentController::class, 'show']);
            Route::put('{equipment}', [EquipmentController::class, 'update']);
            Route::delete('{equipment}', [EquipmentController::class, 'destroy']);
        });
    });
});

// // Rotas para Histórico de Manutenções
// Route::prefix('maintenance-history')->middleware(['api', 'auth:api'])->group(function () {
//     Route::get('/', [MaintenanceHistoryController::class, 'index']);
//     Route::post('/', [MaintenanceHistoryController::class, 'store']);
//     Route::get('{id}', [MaintenanceHistoryController::class, 'show']);
//     Route::put('{id}', [MaintenanceHistoryController::class, 'update']);
//     Route::delete('{id}', [MaintenanceHistoryController::class, 'destroy']);
// });

// // Rotas para Programação de Manutenções
// Route::prefix('maintenance-schedule')->middleware(['api', 'auth:api'])->group(function () {
//     Route::get('/', [MaintenanceScheduleController::class, 'index']);
//     Route::post('/', [MaintenanceScheduleController::class, 'store']);
//     Route::get('{id}', [MaintenanceScheduleController::class, 'show']);
//     Route::put('{id}', [MaintenanceScheduleController::class, 'update']);
//     Route::delete('{id}', [MaintenanceScheduleController::class, 'destroy']);
// });

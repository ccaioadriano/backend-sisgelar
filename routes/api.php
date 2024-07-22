<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Rotas para autenticação
Route::prefix('v1')->group(function () {
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('register', [AuthController::class, 'register']);

    Route::middleware(['auth:api', 'role:super_admin|organization_admin'])->group(function () {
        Route::get('admin/users', [UserController::class, 'index']);
        Route::get('admin/users/{id}', [UserController::class, 'show']);
        Route::post('admin/users', [UserController::class, 'store']);
        Route::put('admin/users/{id}', [UserController::class, 'update']);
        Route::delete('admin/users/{id}', [UserController::class, 'destroy']);
    });

    Route::middleware(['auth:api'])->group(function () {
        Route::get('branches/', [BranchController::class, 'index']);
        Route::prefix('branches/{branch_id}/equipments')->group(function () {
            Route::get('/', [EquipmentController::class, 'index']);
            Route::post('/', [EquipmentController::class, 'store']);
            Route::get('{equipment}', [EquipmentController::class, 'show']);
            Route::patch('{equipment}', [EquipmentController::class, 'update']);
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

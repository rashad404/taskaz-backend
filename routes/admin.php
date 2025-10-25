<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProfessionalController;
use App\Http\Controllers\Admin\CategoryController;

/*
|--------------------------------------------------------------------------
| Admin API Routes
|--------------------------------------------------------------------------
*/

// Authentication routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

// Protected admin routes
Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // User management
    Route::apiResource('users', UserController::class);

    // Professional management
    Route::get('/professionals', [ProfessionalController::class, 'index']);
    Route::get('/professionals/{id}', [ProfessionalController::class, 'show']);
    Route::post('/professionals/{id}/approve', [ProfessionalController::class, 'approve']);
    Route::post('/professionals/{id}/reject', [ProfessionalController::class, 'reject']);
    Route::post('/professionals/{id}/revoke', [ProfessionalController::class, 'revoke']);

    // Category management
    Route::apiResource('categories', CategoryController::class);
    Route::post('/categories/reorder', [CategoryController::class, 'reorder']);

    // Current user
    Route::get('/me', [AuthController::class, 'me']);
});
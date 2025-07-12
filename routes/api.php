<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DivisionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Admin Authentication Routes
Route::post('/login', [AuthController::class, 'login'])->middleware('admin.guest');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:admin');

// Protected Routes - require authentication
Route::middleware('auth:admin')->group(function () {
    Route::get('/divisions', [DivisionController::class, 'index']);
    Route::get('/employees', [\App\Http\Controllers\Api\EmployeeController::class, 'index']);
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

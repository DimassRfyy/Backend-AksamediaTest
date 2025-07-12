<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DivisionController;
use App\Http\Controllers\Api\EmployeeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login'])->middleware('admin.guest');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:admin');

Route::middleware('auth:admin')->group(function () {
    Route::get('/divisions', [DivisionController::class, 'index']);
    Route::apiResource('employees', EmployeeController::class);
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

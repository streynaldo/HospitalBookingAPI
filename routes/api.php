<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\Api\AuthController;


Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login',    [AuthController::class, 'login']);
    Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
});

// Route::get('/doctors', [DoctorController::class, 'index']);

// Pake Token Coba
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/doctors', [DoctorController::class, 'index']);
    // Route::get('/doctors/{doctor}', [DoctorController::class, 'show']);
});

Route::get('/ping', function () {
    return ['message' => 'pong from API'];
});

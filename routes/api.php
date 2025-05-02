<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MahasiswaController;

Route::middleware('auth.basic')->apiResource('dosen', DosenController::class);
Route::middleware('auth.basic')->apiResource('mahasiswa', MahasiswaController::class);
Route::middleware('api.key')->get('/data', function () {
    return response()->json([
        'status' => true,
        'message' => 'Access granted',
        'data' => 'Your protected data',
    ]);
});
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DosenController;

Route::middleware('auth.basic')->apiResource('dosen', DosenController::class);
Route::middleware('api.key')->get('/data', function () {
    return response()->json([
        'status' => true,
        'message' => 'Access granted',
        'data' => 'Your protected data',
    ]);
});

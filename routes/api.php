<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DosenController;

Route::middleware('auth.basic')->apiResource('dosen', DosenController::class);

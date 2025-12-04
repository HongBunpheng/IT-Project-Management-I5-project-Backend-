<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    Route::get('/me', [AuthController::class, 'me'])->middleware('auth:sanctum');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users/me', [UserController::class, 'profile']);
    Route::put('/users/me', [UserController::class, 'updateProfile']);
    Route::put('/users/me/password', [UserController::class, 'changePassword']);
    // Route::put('/users/me/avatar', [UserController::class, 'updateAvatar']);
});

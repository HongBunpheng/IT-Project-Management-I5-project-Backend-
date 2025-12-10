<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\ClassRoomController;

// Buildings
Route::get('/buildings', [BuildingController::class, 'get']);
Route::post('/buildings', [BuildingController::class, 'store']);
Route::get('/buildings/{id}', [BuildingController::class, 'show']);
Route::put('/buildings/{id}', [BuildingController::class, 'update']);
Route::delete('/buildings/{id}', [BuildingController::class, 'destroy']);

// Classes
Route::get('/classes', [ClassRoomController::class, 'get']);
Route::post('/classes', [ClassRoomController::class, 'store']);
Route::get('/classes/{id}', [ClassRoomController::class, 'show']);
Route::put('/classes/{id}', [ClassRoomController::class, 'update']);
Route::delete('/classes/{id}', [ClassRoomController::class, 'destroy']);

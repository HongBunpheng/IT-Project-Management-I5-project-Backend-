<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\AcademicYearController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\ClassRoomController;

// AUTH ROUTES
Route::prefix('auth')->group(function () {

    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/me', [AuthController::class, 'me']);
    });
});

// PROTECTED ROUTES (require token)

Route::middleware('auth:sanctum')->group(function () {

    // USER PROFILE
    Route::get('/users/me', [UserController::class, 'profile']);
    Route::put('/users/me', [UserController::class, 'updateProfile']);
    Route::put('/users/me/password', [UserController::class, 'changePassword']);

    // DEPARTMENTS
    Route::get('/departments', [DepartmentController::class, 'index']);
    Route::post('/departments', [DepartmentController::class, 'store']);
    Route::put('/departments/{id}', [DepartmentController::class, 'update']);
    Route::delete('/departments/{id}', [DepartmentController::class, 'destroy']);

    // ACADEMIC YEARS
    Route::get('/academic-years', [AcademicYearController::class, 'index']);
    Route::post('/academic-years', [AcademicYearController::class, 'store']);
    Route::put('/academic-years/{id}', [AcademicYearController::class, 'update']);
    Route::delete('/academic-years/{id}', [AcademicYearController::class, 'destroy']);

    // SEMESTERS
    Route::get('/semesters', [SemesterController::class, 'index']);
    Route::post('/semesters', [SemesterController::class, 'store']);
    Route::put('/semesters/{id}', [SemesterController::class, 'update']);
    Route::delete('/semesters/{id}', [SemesterController::class, 'destroy']);

    // GROUPS
    Route::get('/groups', [GroupController::class, 'index']);
    Route::post('/groups', [GroupController::class, 'store']);
    Route::put('/groups/{id}', [GroupController::class, 'update']);
    Route::put('/groups/{group_id}/assign-students', [GroupController::class, 'assignStudents']);
    Route::delete('/groups/{id}', [GroupController::class, 'destroy']);
});

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


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
use App\Http\Controllers\TimetableController;
use App\Http\Controllers\QrCodeController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\ScoreController;
use App\Http\Controllers\LeaveRequestController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\NotificationController;

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

    // Timetable
    Route::get('/timetable/user/{user_id}', [TimetableController::class, 'listByUser']);
    Route::get('/timetable/group/{group_id}', [TimetableController::class, 'listByGroup']);
    Route::post('/timetable', [TimetableController::class, 'store']);
    Route::put('/timetable/{id}', [TimetableController::class, 'update']);
    Route::delete('/timetable/{id}', [TimetableController::class, 'destroy']);

    //QR CODE GENERATION
    Route::post('/qrcode/generate', [QrCodeController::class, 'generate']);
    Route::get('/qrcode/{id}', [QrCodeController::class, 'show']);
    Route::get('/qrcode/{id}/download', [QrCodeController::class, 'downloadQrImage']);

    // ATTENDANCE CHECK-IN
    Route::post('/attendance/check-in', [AttendanceController::class, 'checkIn']);
    Route::get('/attendance/timetable/{id}', [AttendanceController::class, 'byTimetable']);
    Route::get('/attendance/user/{id}', [AttendanceController::class, 'myAttendance']);

    //SUBJECT
    Route::get('/subjects', [SubjectController::class, 'index']);
    Route::get('/subjects/{id}', [SubjectController::class, 'show']);
    Route::get('/subjects/semester/{semester_id}', [SubjectController::class, 'bySemester']);
    Route::post('/subjects', [SubjectController::class, 'store']);
    Route::put('/subjects/{id}', [SubjectController::class, 'update']);
    Route::delete('/subjects/{id}', [SubjectController::class, 'destroy']);


    // Exams
    Route::get('/exams/group/{group_id}', [ExamController::class, 'byGroup']);
    Route::get('/exams/{id}', [ExamController::class, 'show']);
    Route::post('/exams', [ExamController::class, 'store']);
    Route::put('/exams/{id}', [ExamController::class, 'update']);
    Route::delete('/exams/{id}', [ExamController::class, 'destroy']);

    // Scores
    Route::get('/scores/user/{user_id}', [ScoreController::class, 'byStudent']);
    Route::get('/scores/exam/{exam_id}', [ScoreController::class, 'byExam']);
    Route::post('/scores', [ScoreController::class, 'store']);
    Route::put('/scores/{id}', [ScoreController::class, 'update']);

    // LEAVE REQUESTS
    Route::post('/leave-requests', [LeaveRequestController::class, 'store']);
    Route::get('/leave-requests/user/{id}', [LeaveRequestController::class, 'byStudent']);
    Route::get('/leave-requests/group/{group_id}', [LeaveRequestController::class, 'byGroup']);
    Route::get('/leave-requests/{id}', [LeaveRequestController::class, 'show']);
    Route::put('/leave-requests/{id}/approve', [LeaveRequestController::class, 'approve']);
    Route::put('/leave-requests/{id}/reject', [LeaveRequestController::class, 'reject']);


    Route::get('/events', [EventController::class, 'index']);
    Route::get('/events/group/{group_id}', [EventController::class, 'byGroup']);
    Route::post('/events', [EventController::class, 'store']);
    Route::put('/events/{id}', [EventController::class, 'update']);
    Route::delete('/events/{id}', [EventController::class, 'destroy']);


    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::put('/notifications/{id}/read', [NotificationController::class, 'markAsRead']);
    Route::put('/notifications/read-all', [NotificationController::class, 'markAllAsRead']);
});

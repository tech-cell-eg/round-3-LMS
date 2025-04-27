<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\StudentController;

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/auth/profile', [AuthController::class, 'profile']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);

    // Courses routes
    Route::controller(CourseController::class)->prefix('courses')->group(function () {
        Route::get('/', 'index');
        Route::get('/{id}', 'show');
        Route::post('/', 'store')->middleware('instructor');
    });

    // Instructors routes
    Route::controller(InstructorController::class)->prefix('instructors')->group(function () {
        Route::post('/{id}/review', 'addReview');
    });
    // Students Filter Routes
    Route::get('/students/courses', [StudentController::class, 'studentCourses']);
    Route::get('/students/instructors', [StudentController::class, 'studentInstructors']);
    Route::get('/students/reviews', [StudentController::class, 'studentReviews']);
});

Route::apiResource('categories', CategoryController::class);

Route::get('/instructors/top',[InstructorController::class, 'topInstructors']);

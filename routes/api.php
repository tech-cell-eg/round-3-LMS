<?php

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/profile', [AuthController::class, 'profile']);
        Route::post('/logout', [AuthController::class, 'logout']);

        // Courses routes
        Route::controller(CourseController::class)->prefix('courses')->group(function () {
            Route::get('/', 'index');
            Route::get('/{id}', 'show');
            Route::post('/', 'store')->middleware('instructor');
        });
    });
});

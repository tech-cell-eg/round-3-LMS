<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\CourseController;
use App\Http\Controllers\Dashboard\LessonController;
use App\Http\Controllers\Dashboard\SyllabusController;

Route::middleware(['auth:sanctum','instructor'])->group(function () {
    Route::apiResource('courses', CourseController::class);
    Route::apiResource('syllabus', SyllabusController::class);
    Route::apiResource('lessons', LessonController::class);
});

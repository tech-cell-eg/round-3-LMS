<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\CourseController;
use App\Http\Controllers\Dashboard\LessonController;
use App\Http\Controllers\Dashboard\SyllabusController;

Route::apiResource('courses', CourseController::class);
Route::apiResource('syllabus', SyllabusController::class);
Route::apiResource('lessons', LessonController::class);

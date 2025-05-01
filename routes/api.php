<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\StudentCourseController;
use App\Http\Controllers\StudentProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CertificationController;
use App\Http\Controllers\CheckController;
use App\Http\Controllers\Dashboard\ReviewsController;
use App\Http\Controllers\StudentProfileShowController;
use App\Http\Controllers\CourseCustomer;
use App\Http\Controllers\Dashboard\CouponsController;
use App\Http\Controllers\Dashboard\CouponsCrudController;
use App\Models\Certification;

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/auth/profile', [AuthController::class, 'profile']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);

    // Instructors routes
    Route::controller(InstructorController::class)->prefix('instructors')->group(function () {
        Route::post('/{id}/review', 'addReview');
    });

    // Students Filter Routes
    Route::controller(StudentProfileController::class)->prefix('students')->group(function () {
        Route::get('/courses','studentCourses');
        Route::get('/instructors','studentInstructors');
        Route::get('/reviews', 'studentReviews');
        Route::get('/messages','studentMessages');
        Route::post('/messages/{id}/send','sendMessage');
    });
    // Student Courses Routes
    Route::get('/students/courses/{id}/', [StudentCourseController::class, 'myCourse']);

    ################################ Instructor Dashboard Routes ################################
    Route::controller(ReviewsController::class)->middleware('instructor')->prefix('instructors')->group(function () {
        Route::get('/reviews', 'myReviews');
    });

    Route::apiResource('/instructors/coupons', CouponsController::class)->middleware('instructor');
});
Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'index'])->middleware('auth:sanctum');
    Route::post('/', [CartController::class, 'store'])->middleware('auth:sanctum');
    Route::delete('/{id}', [CartController::class, 'destroy'])->middleware('auth:sanctum');
});

Route::apiResource('categories', CategoryController::class);

Route::get('/instructors/top',[InstructorController::class, 'topInstructors']);
Route::get('/instructors/changetoInstructor',[InstructorController::class, 'changetoInstructor'])->middleware('auth:sanctum');
// Courses routes
Route::controller(CourseController::class)->prefix('courses')->group(function () {
    Route::get('/', 'index');
    Route::get('/{id}', 'show');
    Route::post('/', 'store')->middleware('instructor');
});
Route::prefix('checkout')->group(function () {
    Route::get('/', [CheckController::class, 'checkout'])->middleware('auth:sanctum');
    Route::get('/success', [CheckController::class, 'success'])->middleware('auth:sanctum')->name('paypal.success');
    Route::get('/cancel', [CheckController::class, 'cancel'])->middleware('auth:sanctum')->name('paypal.cancel');
});

// Students Filter Routes with id
Route::controller(StudentProfileShowController::class)->prefix('students')->group(function () {
    Route::get('/{id}/courses','studentCourses');
    Route::get('/{id}/instructors','studentInstructors');
    Route::get('/{id}/reviews', 'studentReviews');
});
Route::controller(CourseCustomer::class)->prefix('instructorcourse')->group(function () {
    Route::get('/{id}/enrollments', 'index')->middleware(middleware: ['auth:sanctum', 'instructor']);
});


Route::get('/students/certifications/{id}',[CertificationController::class, 'getCertification']);

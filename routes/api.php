<?php

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{CourseCustomer, CartController, AuthController, CheckController};
use App\Http\Controllers\{CourseController, CategoryController, InstructorController};
use App\Http\Controllers\{StudentCourseController, StudentProfileController, InstructorAreaController};
use App\Http\Controllers\{StudentProfileShowController, NotificationController, CertificationController};
// use App\Http\Controllers\{InstructorAreaController, StudentProfileShowController};
use App\Http\Controllers\Dashboard\{ReviewsController, CouponsController, InstructorReviewsController};

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
    Route::apiResource('/instructors/areas', InstructorAreaController::class)->middleware('auth:instructor');

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

    // Coupons Routes
    Route::apiResource('/instructors/coupons', CouponsController::class)->middleware('instructor');
    // Instructor Reviews Routes
    Route::apiResource('/instructors/reviews', InstructorReviewsController::class)->middleware('instructor');
});
Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'index'])->middleware('auth:sanctum');
    Route::post('/', [CartController::class, 'store'])->middleware('auth:sanctum');
    Route::delete('/{id}', [CartController::class, 'destroy'])->middleware('auth:sanctum');
});

Route::apiResource('categories', CategoryController::class);

Route::get('/instructors/top',[InstructorController::class, 'topInstructors']);
Route::post('/instructors/changetoInstructor',[InstructorController::class, 'changetoInstructor'])->middleware('auth:sanctum');
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

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::get('/notifications/unread', [NotificationController::class, 'unread']);
    Route::post('/notifications/{id}/mark-read', [NotificationController::class, 'markAsRead']);
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead']);
    Route::post('/instructors/send-announcement', [NotificationController::class, 'sendAnnouncementToInstructorStudents'])->middleware('instructor');
});

Route::get('/topcourses', [CourseController::class, 'TopThreeCourses']);
Route::get('/totalearnings', [InstructorController::class, 'yearlyEarnings'])->middleware(middleware: ['auth:sanctum', 'instructor']);

Route::get('/students/certifications/{id}',[CertificationController::class, 'getCertification']);
Route::get('/allstudents',[InstructorController::class, 'getAllusersforinstructor'])->middleware(middleware: ['auth:sanctum', 'instructor']);

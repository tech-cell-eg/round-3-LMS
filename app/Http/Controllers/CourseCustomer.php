<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\Enrollment;
use App\Models\Course;
use App\Http\Resources\CourseEnrollmentResource;

class CourseCustomer extends Controller
{
    use ApiResponse;
    //
    public function index($id)
    {
        $user = Auth::user();
    
        $instructor_courses = Course::where('instructor_id', $user->id)->pluck('id');
    
        if ($instructor_courses->isEmpty()) {
            return $this->errorResponse(
                'No courses found for this instructor',
                404
            );
        }
    
        $enrollments = Enrollment::whereIn('course_id', $instructor_courses)
                                 ->where('user_id', $id)
                                 ->get();
    
        if ($enrollments->isEmpty()) {
            return $this->errorResponse(
                'This course is not for this instructor or student not enrolled',
                404
            );
        }
    
        return $this->successResponse(
            CourseEnrollmentResource::collection($enrollments),
            'Enrollments retrieved successfully',
            200
        );
    }
    
    

}

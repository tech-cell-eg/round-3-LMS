<?php

namespace App\Http\Controllers;

use App\Http\Resources\StudentCoursesResource;
use App\Http\Resources\StudentInstructorsResource;
use App\Http\Resources\StudentReviewsResource;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    use ApiResponse;
    public function studentCourses(Request $request)
    {
        $student = $request->user();
        $courses = $student->enrollments()
                ->whereHas('course', function($query) {
                    $query->whereNotNull('instructor_id');
                })
                ->with(['course.reviews', 'course.instructor',  'course.image'])
                ->get();

        return $this->successResponse(StudentCoursesResource::collection($courses), 'Student courses retrieved successfully');
    }

    public function studentInstructors()
    {
        $student = request()->user();
        $instructors = $student->enrollments()
                ->whereHas('course', function($query) {
                    $query->whereNotNull('instructor_id');
                })
                ->with(['course.instructor'])
                ->get()
                ->pluck('course.instructor')
                ->unique('id');

        return $this->successResponse(StudentInstructorsResource::collection($instructors), 'Student instructors retrieved successfully');
    }

    public function studentReviews(Request $request)
    {
        $student = $request->user();

        $reviews = $student->reviews()
            ->whereHas('course', function($query) {
                $query->whereNotNull('instructor_id');
            })
            ->with([
                'course:id,title,instructor_id',
                'course.instructor:id,first_name,last_name'
            ])
            ->latest()
            ->get();

        if ($reviews->isEmpty()) {
            return $this->errorResponse('No reviews found for this student', 404);
        }
        return $this->successResponse(
            StudentReviewsResource::collection($reviews),
            'Student reviews retrieved successfully'
        );
    }
}

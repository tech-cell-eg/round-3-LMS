<?php

namespace App\Http\Controllers;

use App\Http\Resources\ShowMyCourseResource;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class StudentCourseController extends Controller
{
    use ApiResponse;
    public function myCourse(Request $request, $id)
    {
        $student = $request->user();

        $enrollment = $student->enrollments()
            ->whereHas('course', function($query) use ($id) {
                $query->where('id', $id)
                    ->whereNotNull('instructor_id');
            })
            ->with(['course.reviews', 'course.instructor.avatar', 'course.image', 'course.syllabi','user.certifications'])
            ->first();

        if (!$enrollment) {
            return $this->errorResponse('You are not enrolled in this course', 403);
        }

        return $this->successResponse(
            new ShowMyCourseResource($enrollment),
            'Course details retrieved successfully'
        );
    }

}

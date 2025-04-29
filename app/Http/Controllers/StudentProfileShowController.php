<?php

namespace App\Http\Controllers;

use App\Http\Resources\StudentCoursesShowResource;
use App\Http\Resources\StudentReviewsResource;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class StudentProfileShowController extends Controller
{
    use ApiResponse;
    public function studentCourses(Request $request, $id)
    {
        $student = User::find($id);

        // Check if student exists
        if (!$student) {
            return $this->errorResponse('Student not found', 404);
        }

        $query = $student->enrollments()
            ->join('courses', 'enrollments.course_id', '=', 'courses.id')
            ->whereNotNull('courses.instructor_id')
            ->with(['course.reviews', 'course.instructor', 'course.image', 'course.enrollments'])
            ->select('enrollments.*');

        // Apply search filter
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('courses.title', 'like', '%'.$search.'%');
        }

        // Apply sorting
        if ($request->has('sortBy')) {
            $sortBy = $request->input('sortBy');

            if ($sortBy === 'newest') {
                // $query->orderBy('enrollments.created_at', 'desc');
                $query->orderBy('courses.created_at', 'desc');
            }
            elseif ($sortBy === 'highest_rating') {
                $query->leftJoin('reviews', 'courses.id', '=', 'reviews.course_id')
                    ->selectRaw('enrollments.*, AVG(reviews.rating) as average_rating')
                    ->groupBy('enrollments.id')
                    ->orderBy('average_rating', 'desc');
            }
            elseif ($sortBy === 'most_enrolled') {
                $query->leftJoin('enrollments as course_enrollments', 'courses.id', '=', 'course_enrollments.course_id')
                    ->selectRaw('enrollments.*, COUNT(course_enrollments.id) as enrollments_count')
                    ->groupBy('enrollments.id')
                    ->orderBy('enrollments_count', 'desc');
            }
        }

        $courses = $query->get();

        if ($courses->isEmpty()) {
            return $this->errorResponse('No courses found for this student', 404);
        }

        return $this->successResponse(StudentCoursesShowResource::collection($courses), 'Student courses retrieved successfully');
    }

    public function studentReviews($id)
    {
        $student = User::find($id);

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

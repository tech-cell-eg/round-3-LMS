<?php

namespace App\Http\Controllers;

use App\Http\Resources\StudentCoursesResource;
use App\Http\Resources\StudentInstructorsResource;
use App\Http\Resources\StudentReviewsResource;
use App\Models\Message;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class StudentProfileController extends Controller
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

    public function studentMessages(Request $request)
    {
        $student = $request->user();

        $messages = Message::with('sender')
                            ->where('receiver_id',$student->id)
                            ->latest()
                            ->get();


        if ($messages->isEmpty()) {
            return $this->errorResponse('No messages found for this student', 404);
        }
        return $this->successResponse(
            StudentReviewsResource::collection($messages),
            'Student messages retrieved successfully'
        );
    }

    public function sendMessage(Request $request , $id){
        $validated = $request->validate([
            'message' => 'required|string|max:2000',
        ]);

        $sender = $request->user();
        $receiver = User::findOrFail($id);

        // Check if the recipient is an instructor and sender is a student
        if ($sender->role !== 'student' || $receiver->role !== 'instructor') {
            return $this->errorResponse(
                'Invalid message recipients',
                403
            );
        }

        // Check if the sender is student and receiver is his instructor
        $isInstructor = $sender->enrollments()
            ->whereHas('course', function($query) use ($receiver) {
                $query->where('instructor_id', $receiver->id);
            })
            ->exists();
            
        if (!$isInstructor) {
            return $this->errorResponse(
                'You are not student with any course with this instructor',
                403
            );
        }

        Message::create([
            'sender_id' => $sender->id,
            'receiver_id' => $receiver->id,
            'message' => $validated['message'],
        ]);

        return $this->successResponse(
            null,
            'Message sent successfully'
        );
    }
}

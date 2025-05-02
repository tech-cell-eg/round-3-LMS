<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Notifications\InstructorAnnouncementNotification;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class NotificationController extends Controller
{
    use ApiResponse;

    public function index()
    {
        return $this->successResponse(
            Auth::user()->notifications,
            'Notifications fetched successfully'
        );
    }

    public function unread()
    {
        return $this->successResponse(
            Auth::user()->unreadNotifications,
            'Unread notifications successfully'
        );
    }

    public function markAsRead($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        return $this->successResponse(null, 'Notification marked as read successfully');
    }

    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();

        return $this->successResponse(null, 'All notifications marked as read successfully');
    }

    public function sendAnnouncementToInstructorStudents(Request $request)
    {
        // Validate the incoming data
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        // Get all courses for the instructor
        $courses = Course::where('instructor_id', Auth::user()->instructor?->id)->get();

        // Get all students enrolled in the instructor's courses
        $students = Enrollment::with('user') // Load the related user (students)
            ->whereIn('course_id', $courses->pluck('id'))
            ->get()
            ->pluck('user')
            ->unique('id');

        // Send notification to each student
        Notification::send($students, new InstructorAnnouncementNotification(
            message: $request['message'],
            instructor: Auth::user()
        ));

        return $this->successResponse(null, 'Announcement sent successfully');
    }
}

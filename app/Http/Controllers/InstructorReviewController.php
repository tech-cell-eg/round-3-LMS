<?php

namespace App\Http\Controllers;

use App\Http\Requests\Instructors\InstructorReview as InstructorsInstructorReview;
use App\Models\Instructor;
use App\Models\InstructorReview;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class InstructorReviewController extends Controller
{
    use ApiResponse;
    public function addReview(InstructorsInstructorReview $request , $id){
        $validated = $request->validated();
        $user = $request->user();
        $fullName = $user->first_name . ' ' . $user->last_name;
        $instructor = Instructor::find($id);
        if (!$instructor){
            return $this->errorResponse('No instructor found', 404);
        }if($user->id == $instructor->user_id){
            return $this->errorResponse('You cannot review yourself', 403);
        }
        $instructorReview = InstructorReview::create([
            'user_review' => $fullName,
            'instructor_id' => $id,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
        ]);
        $instructor->increment('total_reviews');

        return $this->successResponse(null, 'Rating created successfully', 201);
    }
}

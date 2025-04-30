<?php

namespace App\Http\Controllers;

use App\Http\Requests\Instructors\InstructorReview as InstructorsInstructorReview;
use App\Http\Resources\TopInstructorResource;
use App\Models\Instructor;
use App\Models\InstructorReview;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth ;

class InstructorController extends Controller
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

    public function topInstructors()
    {
        $instructors = Instructor::with(['reviews', 'user'])
            ->orderBy('total_reviews', 'desc')
            ->take(5)
            ->get();

        return $this->successResponse(TopInstructorResource::collection($instructors), 'Top instructors retrieved successfully');
    }

    public function changetoInstructor()
    {
        $user = Auth::user();
        if ($user->role == 'instructor') {
            return $this->errorResponse('You are already an instructor', 403);
        }
        $user->role = 'instructor';
        $user->save();
        return $this->successResponse([
          'user_id'=>$user->id,
          'new_role'=>'instructor',
      ], 'User changed to instructor successfully');
    }
}

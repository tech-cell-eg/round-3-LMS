<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Resources\Dashboard\ReviewsResource;
use App\Http\Resources\PaginationResource;
use App\Models\Review;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class ReviewsController extends Controller
{
    use ApiResponse;
    public function myReviews(Request $request)
    {
        $instructor = $request->user();

        // Load courses with their reviews and the user who made each review
        $reviews = Review::whereHas('course', function($query) use ($instructor) {
                $query->where('instructor_id', $instructor->id);
            })
            ->with(['user.avatar', 'course'])
            ->paginate(1);

        if ($reviews->isEmpty()) {
            return $this->errorResponse(
                'No reviews found.',
                404
            );
        }

        return $this->successResponse(
            [
                'reviews' => ReviewsResource::collection($reviews),
                'pagination' => new PaginationResource($reviews)
            ],
            'Instructor reviews fetched successfully.'
        );
    }
    
}

<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Resources\Dashboard\InstructorReviewsResource;
use App\Http\Resources\PaginationResource;
use App\Models\InstructorReview;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InstructorReviewController extends Controller
{
    use ApiResponse;
    public function index()
    {
        if (!Auth::user()->instructor) {
            return $this->errorResponse('User is not an instructor or instructor profile not found.', 403);
        }

        try {
            $reviews = Auth::user()->instructor->reviews()->with('user')->paginate(5);

            return $this->successResponse(
                [
                    'reviews' =>InstructorReviewsResource::collection($reviews),
                    'pagination' => new PaginationResource($reviews),
                ],
                'Reviews fetched successfully.'
            );
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to fetch reviews: ' . $e->getMessage(), 500);
        }
    }

    public function show($id)
    {
        $review = InstructorReview::with('user')->find($id);

        if (!$review) {
            return $this->errorResponse('Review not found.', 404);
        }

        if ($review->instructor_id !== Auth::user()->instructor->id) {
            return $this->errorResponse('Unauthorized action.', 403);
        }

        return $this->successResponse(
            [
                'review' => new InstructorReviewsResource($review),
            ],
            'Review fetched successfully.'
        );
    }
}

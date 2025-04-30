<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Resources\PaginationResource;
use App\Models\Coupon;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class CouponsController extends Controller
{
    use ApiResponse;
    public function myReviews(Request $request)
    {
        $instructor = $request->user();

        $reviews = Coupon::whereHas('course', function($query) use ($instructor) {
                $query->where('instructor_id', $instructor->id);
            })
            ->with(['user.avatar', 'course'])
            ->paginate(1);

        if ($reviews->isEmpty()) {
            return $this->errorResponse(
                'No coupons found.',
                404
            );
        }

        return $this->successResponse(
            [
                'reviews' => CouponsResource::collection($reviews),
                'pagination' => new PaginationResource($reviews)
            ],
            'Coupons fetched successfully.'
        );
    }
}

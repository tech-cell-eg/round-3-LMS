<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Resources\Dashboard\CouponsResource;
use App\Http\Resources\PaginationResource;
use App\Models\Coupon;
use App\Models\Enrollment;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class CouponsController extends Controller
{
    use ApiResponse;
    public function myCoupons(Request $request)
    {
        $instructor = $request->user();

        // Fetch only the instructor's coupons
        $coupons = Coupon::where('instructor_id', $instructor->id)->paginate(5);

        if ($coupons->isEmpty()) {
            return $this->errorResponse('No coupons found.', 404);
        }

        // Sum of total_price of enrollments that used the instructor's coupons
        $totalPrice = Enrollment::whereNotNull('coupon_id')
            ->whereHas('coupon', function ($query) use ($instructor) {
                $query->where('instructor_id', $instructor->id);
            })
            ->sum('total_price');

        return $this->successResponse(
            [
                'totalCoupons' => $coupons->total(),
                'TotalPriceEarnedWithCoupons' => $totalPrice ?? 0,
                'coupons' => CouponsResource::collection($coupons),
                'pagination' => new PaginationResource($coupons),
            ],
            'Coupons fetched successfully.'
        );
    }
}

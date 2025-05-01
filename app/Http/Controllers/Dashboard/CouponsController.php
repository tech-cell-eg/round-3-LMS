<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCouponRequest;
use App\Http\Requests\UpdateCouponRequest;
use App\Http\Resources\Dashboard\CouponsResource;
use App\Http\Resources\PaginationResource;
use App\Models\Coupon;
use App\Models\Enrollment;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CouponsController extends Controller
{
    use ApiResponse;
    public function index(Request $request)
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

    public function show($coupon)
    {
        $coupon = Coupon::find($coupon);
        if (!$coupon) {
            return $this->errorResponse('Coupon not found.', 404);
        }

        if ($coupon->instructor_id !== auth()->user()->id) {
            return $this->errorResponse('Unauthorized action.', 403);
        }

        return $this->successResponse($coupon, 'Category retrieved successfully');
    }
    public function store(StoreCouponRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['instructor_id'] = $request->user()->id;

        $coupon = Coupon::create($validatedData);

        return $this->successResponse($coupon, 'Coupon created successfully');
    }
    public function update(UpdateCouponRequest $request, $coupon)
    {
        $coupon = Coupon::find($coupon);
        if (!$coupon) {
            return $this->errorResponse('Coupon not found.', 404);
        }

        if ($coupon->instructor_id !== Auth::id()) {
            return $this->errorResponse('Unauthorized action.', 403);
        }

        $validatedData = $request->validated();
        $validatedData['instructor_id'] = $request->user()->id;
        $coupon->update($validatedData);

        return $this->successResponse($coupon, 'Coupon updated successfully');
    }

    public function destroy($id)
    {
        try {
            $coupon = Coupon::findOrFail($id);

            if ($coupon->instructor_id !== auth()->user()->id) {
                return $this->errorResponse('Unauthorized action.', 403);
            }

            $coupon->delete();

            return $this->successResponse(null, 'Coupon deleted successfully');

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->errorResponse('Coupon not found.', 404);
        }
    }
}

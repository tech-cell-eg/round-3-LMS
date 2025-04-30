<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Resources\Dashboard\CouponsResource;
use App\Http\Resources\PaginationResource;
use App\Models\Coupon;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class CouponsController extends Controller
{
    use ApiResponse;
    public function myCoupons(Request $request)
    {
        $instructor = $request->user();

        $reviews = Coupon::paginate(5);

        if ($reviews->isEmpty()) {
            return $this->errorResponse(
                'No coupons found.',
                404
            );
        }

        return $this->successResponse(
            [
                'totalCoupons' => $reviews->total(),
                'reviews' => CouponsResource::collection($reviews),
                'pagination' => new PaginationResource($reviews)
            ],
            'Coupons fetched successfully.'
        );
    }
}

<?php

namespace App\Http\Requests;

use App\Models\Coupon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateCouponRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $couponId = $this->route('coupon');
        $coupon = Coupon::find($couponId);

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $couponId = $this->route('coupon');

        return [
            'offer_name' => 'required|string|max:255|unique:coupons,offer_name,' . $couponId,
            'code' => 'required|string|max:255|unique:coupons,code,' . $couponId,
            'type' => 'required|string|in:percentage,fixed_amount',
            'amount' => 'required|numeric|min:1',
            'quantity' => 'required|integer|min:1',
            'status' => 'required|in:active,expired,draft,scheduled',
        ];
    }
}

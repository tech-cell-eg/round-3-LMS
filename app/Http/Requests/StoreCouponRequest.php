<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreCouponRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check() && Auth::user()->isInstructor();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'offer_name' => 'required|string|max:255|unique:coupons,offer_name',
            'code' => 'required|string|max:255|unique:coupons,code',
            'type' => 'required|string|in:percentage,fixed_amount',
            "amount" => 'required|numeric|min:1',
            "quantity" => 'required|integer|min:1',
            "status" => 'required|in:active,expired,draft,scheduled',
        ];
    }
}

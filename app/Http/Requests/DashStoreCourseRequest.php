<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DashStoreCourseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|numeric|min:0',
            'level' => 'required|string|in:beginner,intermediate,advanced',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:active,inactive',
            'sale' => 'nullable|numeric|min:0',
            'language' => 'nullable|string|max:255',
            'certificate' => 'nullable|boolean',
            
        ];
    }
}

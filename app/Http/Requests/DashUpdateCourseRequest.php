<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DashUpdateCourseRequest extends FormRequest
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
            'name' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
            'price' => 'sometimes|required|numeric|min:0',
            'duration' => 'sometimes|required|numeric|min:0',
            'level' => 'sometimes|required|string|in:beginner,intermediate,advanced',
            'category_id' => 'sometimes|required|exists:categories,id',
            'status' => 'sometimes|required|in:active,inactive',
            'sale' => 'sometimes|nullable|numeric|min:0',
            'language' => 'sometimes|nullable|string|max:255',
            'certificate' => 'sometimes|nullable|boolean',
        ];
    }
}

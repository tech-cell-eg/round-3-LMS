<?php

namespace App\Http\Requests\CourseRequests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCourseRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:0',
            'level' => 'required|in:beginner,intermediate,advanced',
            'description' => 'required|string',
            'video_url' => 'required|url',
            'sale' => 'nullable|numeric|min:0',
            'language' => 'required|string',
            'certificate' => 'required|boolean',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'syllabi' => 'required|array',
            'syllabi.*.title' => 'required|string',
            'syllabi.*.description' => 'nullable|string',
            'syllabi.*.duration' => 'required|integer|min:0',
            'syllabi.*.order' => 'required|integer|min:1',
            'lessons' => 'required|array',
            'lessons.*.title' => 'required|string',
            'lessons.*.video_url' => 'required|url',
            'lessons.*.duration' => 'nullable|integer|min:0',
            'lessons.*.is_preview' => 'required|boolean',
            'lessons.*.order' => 'required|integer|min:1',
        ];
    }
}

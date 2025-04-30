<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLessonRequest extends FormRequest
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
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'video_url' => 'sometimes|nullable|string|required_if:type,video',
            'syllabi_id' => 'sometimes|required|exists:syllabis,id',
            'is_preview' => 'sometimes|required|boolean',
            'duration' => 'sometimes|required|integer',
            'order' => 'sometimes|required|integer',
            'type' => 'sometimes|required|string|in:text,video',
            'text_content' => 'sometimes|nullable|string|required_if:type,text',
        ];
    }
}

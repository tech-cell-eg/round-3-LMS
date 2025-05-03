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
            'title' => 'sometimes|string|max:255',
            'syllabi_id' => 'sometimes|exists:syllabis,id',
            'is_preview' => 'sometimes|boolean',
            'duration' => 'sometimes|integer',
            'order' => 'sometimes|integer',
            'type' => 'sometimes|string|in:text,video,url',
            'lesson_url' => 'nullable|string|required_if:type,url',
            'text' => 'nullable|string|required_if:type,text',
        ];
    }
}

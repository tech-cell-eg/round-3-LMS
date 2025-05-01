<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLessonRequest extends FormRequest
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
            'description' => 'required|string',
            'video_url' => 'nullable|string|required_if:type,video',
            'syllabi_id' => 'required|exists:syllabis,id',
            'is_preview' => 'required|boolean',
            'duration' => 'required|integer',
            'order' => 'required|integer',
            'type' => 'required|string|in:text,video',
            'text_content' => 'nullable|string|required_if:type,text',
        ];
    }
}

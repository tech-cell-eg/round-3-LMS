<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CartRequest extends FormRequest
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
            //
          'course_id' => 'required|exists:courses,id',
          'tax' => 'required|numeric',
          'price' => 'required|numeric',

        ];
    }
    public function messages()
    {
        return [
            'course_id.required' => 'Course ID is required.',
            'course_id.exists' => 'Course ID does not exist.',
            'tax.required' => 'Tax is required.',
            'tax.numeric' => 'Tax must be a number.',
            'price.required' => 'Price is required.',
            'price.numeric' => 'Price must be a number.',
        ];
    }
}

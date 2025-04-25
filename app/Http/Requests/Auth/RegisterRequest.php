<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'username' => 'required|string|unique:users,username',
            'password' => 'required|min:8|regex:/[a-zA-Z]/',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'role' => 'required|in:student,instructor',
            'bio' => 'required_if:role,instructor|string|nullable',
            'title' => 'required_if:role,instructor|string|nullable',
        ];
    }
}

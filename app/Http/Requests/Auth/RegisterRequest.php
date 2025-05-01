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
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'role' => 'required|in:student,instructor',
            'description' => 'required_if:role,instructor|string|nullable',
            'title' => 'required_if:role,instructor|string|nullable',
            'experience' => 'required_if:role,instructor|string|nullable',
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => 'First name is required.',
            'last_name.required' => 'Last name is required.',
            'email.required' => 'Email is required.',
            'email.email' => 'Invalid email format.',
            'email.unique' => 'Email already exists.',
            'username.required' => 'Username is required.',
            'username.unique' => 'Username already exists.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 8 characters.',
            'password.regex' => 'Password must contain at least one letter.',
            'profile_picture.image' => 'Profile picture must be an image.',
            'profile_picture.mimes' => 'Profile picture must be a JPEG, PNG, WEBP, or JPG.',
            'profile_picture.max' => 'Profile picture size must not exceed 2MB.',
            'role.required' => 'Role is required.',
            'bio.required_if' => 'Bio is required for instructors.',
            'bio.string' => 'Bio must be a string.',
            'title.required_if' => 'Title is required for instructors.',
            'title.string' => 'Title must be a string.',
            'experience.required_if' => 'Experience is required for instructors.',
            'experience.string' => 'Experience must be a string.',
        ];
    }
}

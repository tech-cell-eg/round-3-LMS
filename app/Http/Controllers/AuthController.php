<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use ApiResponse;

    public function register(RegisterRequest $request)
    {
        $data = $request->validated();

        /** @var \App\Http\Requests\RegisterRequest $request */
        $imagePath = null;
        if ($request->hasFile('profile_picture')) {
            $image = $request->file('profile_picture');
            $name = uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/profile_pictures'), $name);

            $imagePath = 'uploads/profile_pictures/' . $name;
        }

        $data['password'] = bcrypt($data['password']);

        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => $data['password'],
            'role' => $data['role'] ?? 'student',
        ]);

        if (isset($imagePath)) {
            $user->avatar()->create([
                'path' => $imagePath,
                'imageable_id' => $user->id,
                'imageable_type' => User::class
            ]);
        }

        if ($data['role'] === 'instructor') {
            $user->instructor()->create([
                'title' => $data['title'],
                'bio' => $data['bio'],
                'field' => $data['experience'],
            ]);
        }

        $user['token'] = $user->createToken('auth_token')->plainTextToken;

        return $this->successResponse($user, 'User registered successfully', 201);
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        $user = User::where('email', $credentials['login'])
            ->orWhere('username', $credentials['login'])
            ->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return $this->errorResponse('Invalid credentials', 401);
        }

        $user->load('avatar');

        if ($user->role == 'instructor') {
            $user->load('instructor', 'instructorCourses');
        } elseif ($user->role == 'student') {
            $user->load('enrollments');
        }

        $user->token = $user->createToken('auth_token')->plainTextToken;

        return $this->successResponse(
            new UserResource($user),
            'Logged in successfully'
        );
    }

    public function logout()
    {
        Auth::user()->tokens()->delete();
        return $this->successResponse([], 'Logged out successfully', 200);
    }

    public function profile()
    {
        $user = Auth::user();

        $user->load('avatar');

        if ($user->role == 'instructor') {
            $user->load('instructor', 'instructorCourses');
        } elseif ($user->role == 'student') {
            $user->load('enrollments');
        }

        return $this->successResponse(
            new UserResource($user),
            'Profile fetched successfully'
        );
    }
}

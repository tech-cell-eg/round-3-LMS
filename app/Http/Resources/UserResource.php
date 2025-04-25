<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'user_id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'username' => $this->username,
            'email' => $this->email,
            'role' => $this->role,
            'avatar' => $this->avatar ? asset($this->avatar->path) : null,
        ];
        
        if (isset($this->token)) {
            $data['token'] = $this->token;
        }

        switch ($this->role) {
            case 'instructor':
                $data['instructor'] = new InstructorResource($this->instructor);
                $data['courses'] = $this->instructorCourses;
                break;
            case 'student':
                $data['enrollments'] = $this->enrollments;
                break;
        }

        return $data;
    }
}

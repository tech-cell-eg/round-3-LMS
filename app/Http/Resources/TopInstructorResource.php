<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TopInstructorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'instructor_id' => $this->id,
            'name' => $this->user ? $this->user->first_name . ' ' . $this->user->last_name : null,
            'title' => $this->title,
            'total_reviews' => $this->total_reviews,
            'total_students' => $this->total_students,
        ];
    }
}

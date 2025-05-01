<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InstructorResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'experience' => $this->experience,
            'areas' => InstructorAreaResource::collection($this->areas),
            'total_reviews' => $this->total_reviews,
            'total_students' => $this->total_students,
            'total_courses' => $this->total_courses,
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class StudentCoursesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'course_id' => $this->course?->id,
            'title' => $this->course?->title,
            'instructor' => $this->course->instructor ? $this->course->instructor->first_name . ' ' . $this->course->instructor->last_name : null,
            'rating' => $this->course && $this->course->reviews->isNotEmpty()
                ? round($this->course->reviews->avg('rating'), 1)
                : 0,
            'image' => $this->course?->image ? url(Storage::url($this->course->image->path)) : null,
            'reviews' => $this->course ? [
                'total_ratings' => $this->course->reviews->count(),
                'average_rating' => $this->course->reviews->isNotEmpty()
                    ? round($this->course->reviews->avg('rating'), 1)
                    : 0,
            ] : null,
        ];
    }
}

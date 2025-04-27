<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseIndexResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=> $this->id,
            'title'=> $this->title,
            'image'=> $this->image ? asset('storage/' . $this->image->path) : null,
            'instructor' => $this->instructor->first_name . ' ' . $this->instructor->last_name,
            'rating' => $this->reviews->avg('rating') ?? 0,
            'num_reviews' => $this->reviews->count(),
            'level' => $this->level,
            'price' => $this->price,
            'discount_price' => $this->sale,
            'duration' => $this->duration,
            'num_syllabi' => $this->syllabi->count(),
            'num_lessons' => $this->syllabi->sum(function ($syllabus) {
                return $syllabus->lessons->count();
            }),
        ];
    }
}

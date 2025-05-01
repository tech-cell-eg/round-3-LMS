<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ShowMyCourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $course = $this->course;

        return [
            "id" => $course->id,
            "title" => $course->title,
            "image" => $course->image ? asset('storage/' . $course->image->path) : null,
            "video_url" => $course->video_url,
            "description" => $course->description,
            "duration" => $course->duration,
            "level" => $course->level,
            'syllabi' => SyllabusResource::collection($course->syllabi),

            'instructor' => $course->instructor ? [
                'id' => $course->instructor->id,
                'name' => $course->instructor->first_name . ' ' . $course->instructor->last_name,
                'title' => $course->instructor->instructor->title,
                'description' => $course->instructor->instructor->description,
                'image' => $course->instructor->avatar ? url(Storage::url($course->instructor->avatar->path)) : null,
            ] : null,

            'reviews' => ReviewResource::collection($course->reviews),
        ];
    }

}

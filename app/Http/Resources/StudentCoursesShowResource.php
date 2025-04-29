<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class StudentCoursesShowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $userId = $this->id;

        $totalCourseDuration = $this->course->syllabi()->sum('duration');
        $watchedDuration = $this->course->lessonProgress()
            ->where('user_id', $userId)
            ->sum('watch_duration');

        $progressPercentage = $totalCourseDuration > 0
            ? round(($watchedDuration / $totalCourseDuration) * 100, 2)
            : 0;

        return [
            'course_id' => $this->course->id,
            'title' => $this->course->title,
            'instructor' => $this->course->instructor ?
                $this->course->instructor->first_name . ' ' . $this->course->instructor->last_name :
                null,
            'rating' => $this->course->reviews->isNotEmpty()
                ? round($this->course->reviews->avg('rating'), 1)
                : 0,
            'image' => $this->course->image ? url(Storage::url($this->course->image->path)) : null,
            'reviews' => [
                'total_ratings' => $this->course->reviews->count(),
                'average_rating' => $this->course->reviews->isNotEmpty()
                    ? round($this->course->reviews->avg('rating'), 1)
                    : 0,
            ],
            // 'progress' => [
            //     'percentage' => $progressPercentage,
            //     'watched_duration' => $watchedDuration,
            //     'course_total_duration' => $totalCourseDuration,
            // ],
        ];
    }
}

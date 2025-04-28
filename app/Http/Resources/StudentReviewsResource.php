<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentReviewsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'review_id' => $this->id,
            'course' => [
                'id' => $this->course->id,
                'title' => $this->course->title,
                // 'instructor' => [
                //     'id' => $this->course->instructor->id,
                //     'name' => $this->course->instructor->first_name . ' ' .
                //                 $this->course->instructor->last_name
                // ],
                'comment' => $this->comment,
                'rating' => (float) $this->rating,
            ],

        ];
    }
}

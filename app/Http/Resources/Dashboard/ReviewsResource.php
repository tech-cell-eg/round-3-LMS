<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->first_name . ' ' . $this->user->last_name,
                'avatar' => $this->user->avatar
                    ? asset('storage/' . ltrim($this->user->avatar->path, '/'))
                    : null,
            ],
            'course' => [
                'id' => $this->course->id,
                'title' => $this->course->title,
            ],
            'rating' => $this->rating,
            'comment' => $this->comment,
            'created_at' => $this->created_at ? $this->created_at->diffForHumans() : null,
        ];
    }
}

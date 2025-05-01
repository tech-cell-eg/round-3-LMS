<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CertificationResource extends JsonResource
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
            'user' => $this->whenLoaded('user', function () {
                return [
                    'id' => $this->user->id,
                    'name' => $this->user->first_name . ' ' . $this->user->last_name,
                ];
            }),
            'course' => $this->whenLoaded('course', function () {
                return [
                    'id' => $this->course->id,
                    'title' => $this->course->title,
                    'instructor' => $this->when(
                        $this->course->relationLoaded('instructor') &&
                        $this->course->instructor &&
                        $this->course->instructor->relationLoaded('user'),
                        function () {
                            return [
                                'id' => $this->course->instructor->id,
                                'name' => $this->course->instructor->user->first_name . ' ' .
                                            $this->course->instructor->user->last_name
                            ];
                        }
                    )
                ];
            }),
            'issued_date' => $this->issued_date,
        ];
    }
}

<?php

namespace App\Http\Resources\Dashboard;

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
            "title"=> $this->title,
            'price'=> $this->price,
            'section_count'=> $this->syllabi_count,
            'review_count'=> $this->reviews_count,
            'order'=> $this->enrollments_count,
            'shelf' => $this->favorites_count,
        ];
    }
}

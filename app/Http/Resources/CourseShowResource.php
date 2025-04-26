<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\SyllabusResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseShowResource extends JsonResource
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
            'description'=> $this->description,
            'category'=> $this->category->name,
            'language'=> $this->language,
            'certificate'=> (bool) $this->certificate,
            'video_url'=> $this->video_url,
            'instructor' => $this->instructor->first_name . ' ' . $this->instructor->last_name,
            'rating' => $this->reviews->avg('rating') ?? 0,
            'num_reviews' => $this->reviews->count(),
            'level' => $this->level,
            'price' => $this->price,
            'discount_price' => $this->sale,
            'duration' => $this->duration,
            'favorite' => $this->favorites ? true : false,
            'syllabi' => SyllabusResource::collection($this->syllabi),
        ];
    }
}

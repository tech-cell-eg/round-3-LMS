<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SyllabusResource extends JsonResource
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
            'description'=> $this->description,
            'duration_in_mins'=> $this->duration,
            'order'=> $this->order,
            'lessons'=> LessonResource::collection($this->lessons),
        ];
    }
}

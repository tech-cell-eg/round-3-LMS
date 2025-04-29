<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LessonResource extends JsonResource
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
            'video_url'=>  $this->video_url == true ? $this->video_url : null,
            'duration'=> $this->duration,
            'is_preview'=> (bool) $this->is_preview,
            'order'=> $this->order,
        ];
    }
}

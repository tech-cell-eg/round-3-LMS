<?php

namespace App\Http\Resources\Dashboard;

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
            'section_id'=> $this->syllabi_id,
            'title' => $this->title,
            'duration' => $this->duration,
            'is_preview' => $this->is_preview,
            'order' => $this->order,
            'type'=> $this->type,
            'content' => $this->type === 'text' ? $this->text_content : $this->video_url,
        ];
    }
}

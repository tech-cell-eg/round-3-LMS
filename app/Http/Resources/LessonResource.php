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
            "id" => $this->id,
            'title' => $this->title,
            'type' => $this->type ?: null,
            'lesson_url' => $this->type === 'text' ? null : ($this->lesson_url ?: null),
            'text' => $this->type === 'text' ? $this->text : null,
            'duration_in_mins' => $this->duration,
            'completed' => (bool) $this->is_preview,
            'order' => $this->order,
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class StudentInstructorsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'instructor_id' => $this->id,
            'instructor' => $this->first_name . ' ' . $this->last_name,
            'title' => $this->instructor->title ?? null,
            'image' => $this->avatar ? url(Storage::url($this->avatar->path)) : null,
        ];
    }
}

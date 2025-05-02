<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Request;
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
            "title"=> $this->title,
            'price'=> $this->price,
            'description'=> $this->description,
            'image'=> $this->image->path,
            'category'=> $this->category->name,
            'status'=> $this->status,
            'sale'=> $this->sale,
            'language'=> $this->language,
            'level'=> $this->level,
        ];
    }
}

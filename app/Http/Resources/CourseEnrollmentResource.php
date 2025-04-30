<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseEnrollmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
          'Order ID' => $this->id,
          'Type' => $this->role,
          'Joined' => $this->created_at->format('Y-m-d H:i'),
          'Total Amount'=> $this->total_price,
          'Discount'=> $this->discount_percentage,
          'Discount Code'=> $this->discount_code, 
          'customer_id'=> $this->user_id,
        ]
        ;
    }
}

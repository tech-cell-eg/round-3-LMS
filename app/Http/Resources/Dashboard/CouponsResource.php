<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CouponsResource extends JsonResource
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
            'offer_name' => $this->offer_name,
            'code' => $this->code,
            'type' => $this->type,
            'amount' => $this->amount,
            'quantity' => $this->quantity,
            'redemptions' => $this->redemptions,
            'status' => $this->status,
        ];
    }
}

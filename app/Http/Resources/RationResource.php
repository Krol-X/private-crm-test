<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RationResource extends JsonResource
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
            'order_id' => $this->order_id,
            'cooking_date' => $this->cooking_date->format('Y-m-d'),
            'cooking_day_before' => $this->cooking_day_before,
            'delivery_date' => $this->delivery_date->format('Y-m-d'),
            'order' => new OrderResource($this->whenLoaded('order')),
        ];
    }
}

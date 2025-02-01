<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'client_name' => $this->client_name,
            'client_phone' => $this->client_phone,
            'tariff_id' => $this->tariff_id,
            'schedule_type' => $this->schedule_type,
            'comment' => $this->comment,
            'created_at' => $this->created_at->format('Y-m-d'),
            'first_date' => $this->first_date->format('Y-m-d'),
            'last_date' => $this->last_date->format('Y-m-d'),
            'tariff' => new TariffResource($this->whenLoaded('tariff')),
        ];
    }
}

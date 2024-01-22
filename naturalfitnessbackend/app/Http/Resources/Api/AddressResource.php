<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'latitude' => $this->latitude ?? '',
            'longitude' => $this->longitude ?? '',
            'full_address' => $this->full_address,
            'zip_code' => $this->zip_code,
            'type' => $this->type,
            'is_default' => $this->is_default,
        ];
    }
}

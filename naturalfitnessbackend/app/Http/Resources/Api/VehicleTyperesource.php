<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VehicleTyperesource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "uuid" => $this->uuid,
            "name" => $this->name,
            "image" => $this->display_image,
            "type" => $this->type,
            'is_active' => (bool)$this->is_active,
            'sub_types' => VehicleTyperesource::collection($this->subCategory),
        ];
    }
}

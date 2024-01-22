<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VehicleResource extends JsonResource
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
            "registration_number" => $this->registration_number ?? "",
            "company" => $this->vehicleCompany?->name ?? "",
            "type" => $this->vehicleType?->name ?? "",
            "sub_type" => $this->vehicleSubType?->name ?? "",
            "body_type" => $this->vehicleBodyType?->name ?? "",
            "rc_front" => $this->vehicleDocument('rc_front'),
            "rc_back" => $this->vehicleDocument('rc_back'),
            "vehicle_image" => $this->vehicleDocument('vehicle_image'),
            "helper_count" => $this->helper_count,
            'is_active' => (bool)$this->is_active,
        ];
    }
}

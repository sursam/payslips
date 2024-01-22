<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use PhpParser\Node\Expr\Cast\Object_;

class DriverBasicResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $vehicleInfo = $this->vehicle ? new VehicleResource($this->vehicle) : (Object)[];
        return [
            'uuid' => $this->uuid,
            'name' => $this->first_name.' '.$this->last_name ?? "",
            'user_name' => $this->username,
            'email' => $this->email ?? '',
            'phone' => $this->mobile_number,
            "profile_image" => $this->profile_picture ?? "",
            'is_branding' => $this->is_branding,
            'is_online' => $this->is_online,
            'vehicle' => $vehicleInfo
        ];
    }
}

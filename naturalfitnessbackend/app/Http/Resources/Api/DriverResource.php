<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use PhpParser\Node\Expr\Cast\Object_;

class DriverResource extends JsonResource
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
            'step' => $this->registration_step ?? 0,
            'uuid' => $this->uuid,
            'token'=> $this->createToken('access-token')->accessToken,
            'name' => $this->first_name.' '.$this->last_name ?? "",
            'user_name' => $this->username,
            'email' => $this->email ?? '',
            'phone' => $this->mobile_number,
            "profile_image" => $this->profile_picture ?? "",
            "aadhar_front" => $this->userDocument('aadhar_front'),
            "aadhar_back" => $this->userDocument('aadhar_back'),
            "licence_front" => $this->userDocument('licence_front'),
            "licence_back" => $this->userDocument('licence_back'),
            'is_branding' => $this->is_branding,
            'is_online' => $this->is_online,
            'vehicle' => $vehicleInfo
            //'profile' => new ProfileResource($this->profile),
        ];
    }
}

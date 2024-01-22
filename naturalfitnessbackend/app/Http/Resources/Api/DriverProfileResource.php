<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use PhpParser\Node\Expr\Cast\Object_;

class DriverProfileResource extends JsonResource
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
            "is_aadhar_approved" => $this->mediaStatus('aadhar_front'),
            "aadhar_front" => $this->userDocument('aadhar_front'),
            "aadhar_back" => $this->userDocument('aadhar_back'),
            "is_licence_approved" => $this->mediaStatus('licence_front'),
            "licence_front" => $this->userDocument('licence_front'),
            "licence_back" => $this->userDocument('licence_back'),
            'is_branding' => $this->is_branding,
            'is_online' => $this->is_online,
            'wallet' => $this->wallet,
            'branding_text' => getSiteSetting('branding_details'),
            "rc_front" => $this->vehicle?->vehicleDocument('rc_front'),
            "rc_back" => $this->vehicle?->vehicleDocument('rc_back'),
            "vehicle_image" => $this->vehicle?->vehicleDocument('vehicle_image')
            //'wallet' => new WalletResource($this->wallet)
        ];
    }
}

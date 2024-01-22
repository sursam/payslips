<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingAddressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $response = [];
        foreach ((array) $this->all() as $value){
            $data = [
                    'uuid' => $value['uuid'],
                    'full_address' => $value['full_address'],
                    'zip_code' => $value['zip_code'],
                    'latitude' => $value['latitude'],
                    'longitude' => $value['longitude'],
                    'address_type' => $value['address_type'],
            ];
            if($value['type'] == 'pickup'){
                $response[$value['type']] = $data;
            }else{
                $response[$value['type']][] = $data;
            }
        }
        return $response;
    }
}

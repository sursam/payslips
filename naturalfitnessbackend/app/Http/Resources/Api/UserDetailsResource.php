<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserDetailsResource extends JsonResource
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
            'name' => $this->first_name.' '.$this->last_name,
            'user_name' => $this->username,
            'email' => $this->email ?? '',
            'phone' => $this->mobile_number,
            'profile' => new ProfileResource($this->profile)
        ];
    }
}

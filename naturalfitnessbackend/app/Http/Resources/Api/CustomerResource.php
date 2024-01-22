<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use PhpParser\Node\Expr\Cast\Object_;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'step' => $this->registration_step ?? 0,
            'uuid' => $this->uuid,
            'token'=> $this->createToken('access-token')->accessToken,
            'name' => $this->first_name.' '.$this->last_name ?? "",
            'user_name' => $this->username,
            'email' => $this->email ?? '',
            'phone' => $this->mobile_number,
            "profile_image" => $this->profile_picture ?? "",
            'is_registered' => $this->is_registered,
            'profile' => new ProfileResource($this->profile),
        ];
    }
}

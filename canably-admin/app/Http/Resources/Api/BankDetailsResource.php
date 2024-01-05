<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class BankDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'first_name' => $this?->first_name,
            'last_name' => $this?->last_name,
            'bank' => $this?->bank,
            'account'=>$this?->account,
            'ach'=>$this?->ach
        ];
    }
}

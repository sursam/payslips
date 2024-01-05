<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NewsLetterResource extends JsonResource
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
            'First Name'=>$this->first_name,
            'Last Name'=>$this->last_name,
            'Email Address'=>$this->email,
            'Contact Number'=>$this->mobile_number,
            'Subscribed'=>$this->is_subscribed ? 'YES' : 'NO',
            // 'Subscribed At'=>$this->created_at
        ];
    }
}

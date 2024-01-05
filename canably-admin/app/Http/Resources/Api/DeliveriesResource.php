<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class DeliveriesResource extends JsonResource
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
            'order' => new OrderResource($this->order),
            'status' => $this->accepted_at && !$this->rejected_at ? true : false,
            'delivery_status' => $this->order->delivery_status,
            'is_completed' => (bool)$this->is_completed,
        ];
    }
}

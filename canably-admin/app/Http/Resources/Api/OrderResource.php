<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $details= $this->details;
        $total= number_format($this->details?->first()->shipping_cost+ $details?->sum(function($details){
            return $details->quantity*$details->discounted_price;
        }),2);
        return [
            'uuid' => $this->uuid,
            'order_no' => $this->order_no,
            'name'=>$this->orderAddress?->name,
            'phone_number'=>$this->orderAddress?->phone_number,
            'expected_delivery'=>$this->delivered_at ?? Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
            'total'=>$total,
            'address'=>implode(',',$this->orderAddress->full_address),
            'quantity'=>$this->details?->sum('quantity') ?? 0
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Support\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class EarningsResource extends JsonResource
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
            'text'=>'Delivery payout amount',
            'transaction_at'=>Carbon::parse($this->transactioned_at)->format('Y-m-d'),
            'amount'=>$this->amount,
        ];
    }
}

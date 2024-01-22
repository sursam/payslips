<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "uuid" => $this->uuid,
            "transaction_no" => $this->transaction_no,
            "amount" => $this->amount,
            "currency" => $this->currency,
            "type" => $this->type,
            "payment_gateway" => $this->payment_gateway,
            "payment_gateway_id" => $this->payment_gateway_id,
            "payment_gateway_uuid" => $this->payment_gateway_uuid,
            "json_response" => $this->json_response,
            "status" => $this->status,
            "created_at" => $this->created_at,
            "user" => new UserDetailsResource($this->user),
        ];
    }
}

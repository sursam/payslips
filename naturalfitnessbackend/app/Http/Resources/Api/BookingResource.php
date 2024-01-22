<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use PhpParser\Node\Expr\Cast\Object_;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Api\BookingAddressResource;

class BookingResource extends JsonResource
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
            'name' => $this->name,
            'mobile_number' => $this->mobile_number,
            "type" => $this->vehicleType?->name ?? "",
            "payment_mode" => $this->paymentMode?->name ?? "",
            'is_other' => $this->is_other ?? 0,
            'price' => $this->price,
            'status' => $this->status ?? 0,
            'verification_code' => $this->verification_code ?? 0,
            'scheduled_at' => $this->scheduled_at,
            'addresses' => new BookingAddressResource($this->addresses),
            'driver' => $this->bookingDriver?->driver ? new DriverBasicResource($this->bookingDriver->driver) : null,
        ];
    }
}

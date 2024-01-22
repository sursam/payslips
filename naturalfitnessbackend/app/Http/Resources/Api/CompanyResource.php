<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $document = asset('storage/no-image.png');
        if(!empty($this->document)){
            $document = asset('storage/documents/module') .'/'. $this->document;
        }
        return [
            'uuid' => $this->uuid,
            'name' => $this->name,
            'is_active' => (bool)$this->is_active,
            /*'id' => $this->id,
            'company_name' => $this->company_name,
            'business_name' => $this->business_name,
            'user_id' => $this->user_id,
            'registration_number' => $this->registration_number,
            'vat_no' => $this->vat_no,
            'website' => $this->website,
            'document' => $document,
            'description' => $this->description,
            'registered_address' => $this->registered_address,
            'trading_address' => $this->trading_address,
            'trade_started_at' => $this->trade_started_at,
            'ownership' => $this->ownership,
            'turnover' => $this->turnover,
            'employeees' => $this->employeees,*/
        ];
        // return parent::toArray($request);
    }
}

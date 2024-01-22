<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use App\Http\Resources\Api\ModuleFieldsOptionResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ModuleFieldsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'question' => $this->question,
            'type' => $this->type,
            'place_holder' => $this->place_holder,
            'max_length' => $this->max_length,
            'is_mandatory' => $this->is_mandatory == 0,
            'fields' => ModuleFieldsOptionResource::collection($this->moduleFieldOption)
        ];
    }
}

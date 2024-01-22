<?php

namespace App\Http\Resources\Ajax;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ToolGroupResource extends JsonResource
{
    /**
     * Transform the resource into an array.details
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $details= $this->details;
        return [
            'name'=>implode(",",$details->pluck('tag.name')->toArray()),
            "value"=>implode(",",$details->pluck('tag.slug')->toArray())
        ];
    }
}

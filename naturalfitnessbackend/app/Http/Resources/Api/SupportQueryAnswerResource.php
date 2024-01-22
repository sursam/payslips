<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SupportQueryAnswerResource extends JsonResource
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
            "answer" => $this->answer,
            "post_date" => \Carbon\Carbon::parse($this->created_at)->format('d M Y \\a\\t\\ H:i A')
        ];
    }
}

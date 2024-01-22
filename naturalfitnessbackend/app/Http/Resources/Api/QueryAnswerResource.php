<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QueryAnswerResource extends JsonResource
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
            "topic" => $this->topic,
            "question" => $this->question,
            "answer" => SupportQueryAnswerResource::collection($this->supportAnswer),
        ];
    }
}

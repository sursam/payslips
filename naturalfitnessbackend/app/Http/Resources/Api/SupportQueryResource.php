<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SupportQueryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if($this->category_id == null){
            $topic = $this->topic;
        }else{
            $topic = $this->category?->name;
        }
        return [
            "uuid" => $this->uuid,
            "topic" => $topic,
            "queries" => $this->question,
            "post_date" => \Carbon\Carbon::parse($this->created_at)->format('d M Y \\a\\t\\ H:i A')
        ];
    }
}

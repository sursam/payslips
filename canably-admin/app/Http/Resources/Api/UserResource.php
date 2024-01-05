<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $dataArray= [
            'uuid' => $this->uuid,
            'full_name' => $this->full_name,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'username' => $this->username,
            'email' => $this->email,
            'unread_notifications' => $this->unreadNotifications->count(),
            'total_earning' => $this->total_earning ?? 0,
            'profile_picture' => $this->profile_picture,
            'profile'=>new ProfileResource($this->profile),
            'driving_license'=>$this->driving_license,
            'deliveries'=>DeliveriesResource::collection($this->deliveries->where('status',true)->sortByDesc('id')),
        ];
        if(request()->route()->getName()=='auth.login'){
            $tokenArray= ['access_token'=> $this->createToken('access-token')->accessToken];
            $dataArray=array_merge($dataArray,$tokenArray);
        }
        return $dataArray;
    }
}

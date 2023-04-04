<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SlugResource extends JsonResource
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
            'id' => $this->id,
            'railway' => $this->railway->name,
            'organization' => $this->organization_name,
            'user' => new UserInfoResource($this->user),
            'fullname' => $this->cadry->last_name . ' ' . $this->cadry->first_name . ' ' . $this->cadry->middle_name,
            'photo' => url(asset('storage/' . $this->cadry->photo)),
            'created_at' => $this->created_at
        ];
    }
}

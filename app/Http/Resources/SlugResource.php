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
            'user' => new UserInfoResource($this->user),
            'name' => $this->name,
            'url' => url(asset('odas/reception/' . $this->name)),
            'expires_at' => $this->expires_at,
            'created_at' => $this->created_at
        ];
    }
}

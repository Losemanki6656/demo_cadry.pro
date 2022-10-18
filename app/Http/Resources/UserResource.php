<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\RoleResource;

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
        return [
            'id' => $this->id,
            'name' => $this->name,
            'photo' => url(asset($this->userorganization->photo)),
            'phone' => $this->userorganization->phone,
            'email' => $this->email,
            'organization' => new OrganizationResource($this->userorganization->organization),
            'roles' => new RoleResource($this->roles->first())
        ];
    }
}

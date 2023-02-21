<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserApiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $phone = null; $photo = null; $organization = null;
        
        if($this->userorganization) {
            $photo = url(asset($this->userorganization->photo));
            $phone = $this->userorganization->phone;
            $organization = new OrganizationResource($this->userorganization->organization);
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'photo' => $photo,
            'phone' => $phone,
            'email' => $this->email,
            'organization' => $organization,
            'roles' => new RoleapiResource($this->roles->first())
        ];
    }
}

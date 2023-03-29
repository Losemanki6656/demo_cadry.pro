<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserInfoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $photo = null; 
        
        if($this->userorganization) {
            $photo = url(asset($this->userorganization->photo));
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'photo' => $photo,
        ];
    }
}

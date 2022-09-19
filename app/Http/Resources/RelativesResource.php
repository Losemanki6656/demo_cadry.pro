<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RelativesResource extends JsonResource
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
            'relative' => $this->relative_id,
            'fullname' => $this->fullname,
            'birth_place' => $this->birth_place,
            'post' => $this->post,
            'address' => $this->address,
        ];
    }
}

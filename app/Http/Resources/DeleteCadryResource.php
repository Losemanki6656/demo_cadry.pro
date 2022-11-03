<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DeleteCadryResource extends JsonResource
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
            'photo' => url(asset('storage/' . $this->photo)),
            'fullname' => $this->last_name . ' ' . $this->first_name . ' ' . $this->middle_name,
            'organization' => new OrganizationResource($this->organization),
            'command_number' => $this->number,
            'comment' => $this->comment
        ];
    }
}

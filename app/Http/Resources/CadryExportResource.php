<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CadryExportResource extends JsonResource
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
            'organization' => $this->organization->name,
            'fullname' => $this->last_name . ' ' . $this->first_name . ' ' . $this->middle_name
        ];
    }
}

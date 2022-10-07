<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CadryStaffResource extends JsonResource
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
            'staff_full' => $this->staff_full,
        ];
    }
}

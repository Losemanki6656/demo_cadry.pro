<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DualResource extends JsonResource
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
            'profession' => $this->profession,
            'technical' => new TechnicalResource($this->technical),
            'specialty' => new SpecialtyResource($this->specialty),

        ];
    }
}

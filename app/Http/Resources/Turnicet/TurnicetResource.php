<?php

namespace App\Http\Resources\Turnicet;

use Illuminate\Http\Resources\Json\JsonResource;

class TurnicetResource extends JsonResource
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
            'status' => $this->status,
            'deviceName' => $this->devicename,
            'date' => $this->date,
            'time' => $this->time,
        ];
    }
}

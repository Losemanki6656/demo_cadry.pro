<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DisciplinaryActionResource extends JsonResource
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
            'command_number' => $this->number,
            'date_punishment' => $this->date_action,
            'type_punishment' => $this->type_action,
            'reason_punishment' => $this->reason_action,
        ];
    }
}

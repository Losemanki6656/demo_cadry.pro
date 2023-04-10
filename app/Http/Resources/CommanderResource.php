<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommanderResource extends JsonResource
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
            'cadry' => new CommanderCadryResource($this->cadry),
            'user' => new UserInfoResource($this->user),
            'country' => new CountryResource($this->country),
            'commander_payment' => new CommanderPaymentResource($this->commander_payment),
            'commander_pupose' => new CommanderPuposeResource($this->commander_pupose),
            'position' => $this->position,
            'command_number' => $this->command_number,
            'date_command' => $this->date_command,
            'date1' => $this->date1,
            'date2' => $this->date2,
            'days' => $this->days,
            'reason' => $this->reason,
            'status' => $this->status
        ];
    }
}

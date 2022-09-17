<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class IncentiveResource extends JsonResource
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
            'by_whom' => $this->by_whom,
            'command_number' => $this->number,
            'incentive_date' => $this->incentive_date,
            'type_incentive' => $this->type_action,
            'reason_incentive' => $this->type_reason,
            'status' => $this->status
        ];
    }
}

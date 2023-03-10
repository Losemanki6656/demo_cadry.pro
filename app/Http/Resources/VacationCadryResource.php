<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VacationCadryResource extends JsonResource
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
            'date1' => $this->date1->format('Y-m-d'),
            'date2' => $this->date2->format('Y-m-d'),
            'status_decret' => $this->status_decret,
            'command_number' => $this->command_number,
            'period1' => $this->period1,
            'period2' => $this->period2,
            'alldays' => $this->alldays,
            'cadry' => new CadryVacationResource($this->cadry)
        ];
    }
}

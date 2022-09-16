<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VacationIntegrationResource extends JsonResource
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
            'period1' => $this->date1->format('Y-m-d'),
            'period2' => $this->date2->format('Y-m-d'),
            'all_days' => $this->alldays,
            'cadry_pinfl' => $this->cadry->jshshir,
        ];
    }
}

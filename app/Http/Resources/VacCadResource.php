<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VacCadResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if($this->date1 < now()) $days = (-1)*($this->date1->diffInDays()); 
            else
        $days = $this->date1->diffInDays(); 

        return [
            'id' => $this->id,
            'cadry' => new CadryResource($this->cadry),
            'period1' => $this->period1,
            'period2' => $this->period2,
            'date1' => $this->date1->format('Y-m-d'),
            'days' => $days
        ];
    }
}

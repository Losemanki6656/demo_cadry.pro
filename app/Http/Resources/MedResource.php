<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MedResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if($this->date2->diffInDays() < 0) $days = (-1)*($this->date2->diffInDays()); 
            else
        $days = $this->date2->diffInDays(); 

        return [
            'id' => $this->id,
            'cadry_id' => $this->cadry_id,
            'photo' => url(asset('storage/' . $this->photo)),
            'fullname' => $this->last_name . ' ' . $this->first_name . ' ' . $this->middle_name,
            'date1' => $this->date1,
            'date2' => $this->date2,
            'days' => $days
        ];
    }
}

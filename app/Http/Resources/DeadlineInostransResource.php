<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DeadlineInostransResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if($this->date_inostrans) {
            if($this->date_inostrans < now()) 
                $days = (-1)*($this->date_inostrans->diffInDays()); 
            else
                $days = $this->date_inostrans->diffInDays(); 
        } else $days = null;

        return [
            'id' => $this->id,
            'photo' => url(asset('storage/' . $this->photo)),
            'fullname' => $this->last_name . ' ' . $this->first_name . ' ' . $this->middle_name,
            'date' => optional($this->date_inostrans)->format('Y-m-d'),
            'days' => $days
        ];
    }
}

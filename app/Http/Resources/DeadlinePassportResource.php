<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DeadlinePassportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if($this->pass_date2) {
            if($this->pass_date2 < now()) 
                $days = (-1)*($this->pass_date2->diffInDays()); 
            else
                $days = $this->pass_date2->diffInDays(); 
        } else $days = null;

        return [
            'id' => $this->id,
            'photo' => url(asset('storage/' . $this->photo)),
            'fullname' => $this->last_name . ' ' . $this->first_name . ' ' . $this->middle_name,
            'date' => optional($this->pass_date2)->format('Y-m-d'),
            'days' => $days
        ];
    }
}

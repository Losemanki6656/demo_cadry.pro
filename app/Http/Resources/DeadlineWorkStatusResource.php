<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DeadlineWorkStatusResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if($this->work_date2) {
            if($this->work_date2 < now()) 
                $days = (-1)*($this->work_date2->diffInDays()); 
            else
                $days = $this->work_date2->diffInDays(); 
        } else $days = null;
       

        return [
            'id' => $this->id,
            'photo' => url(asset('storage/' . $this->cadry->photo)),
            'fullname' => $this->cadry->last_name . ' ' . $this->cadry->first_name . ' ' . $this->cadry->middle_name,
            'date' => optional($this->work_date2)->format('Y-m-d'),
            'days' => $days
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DeadlineVacationResource extends JsonResource
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
            'photo' => url(asset('storage/' . $this->cadry->photo)),
            'fullname' => $this->cadry->last_name . ' ' . $this->cadry->first_name . ' ' . $this->cadry->middle_name,
            'period1' => $this->period1,
            'period2' => $this->period2,
            'date' => $this->date1->format('Y-m-d')
        ];
    }
}

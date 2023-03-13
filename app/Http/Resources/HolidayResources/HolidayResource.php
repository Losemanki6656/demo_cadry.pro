<?php

namespace App\Http\Resources\HolidayResources;

use Illuminate\Http\Resources\Json\JsonResource;

class HolidayResource extends JsonResource
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
            'name' => $this->holiday_name,
            'day' => (int)$this->holiday_date->format('d'),
            'weekends' => $this->weekends,
            'holiday' => $this->holiday,
            'old_holiday' => $this->old_holiday
        ];
    }
}

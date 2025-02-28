<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class DeadlinePassportResource extends JsonResource
{
    public function toArray($request)
    {
        if($this->pass_date2) {
            $pass_date2 = Carbon::parse($this->pass_date2);
            if($pass_date2 < now()) {
                $days = (-1) * ($pass_date2->diffInDays());
            }
            else {
                $days = $pass_date2->diffInDays();
            }
        } else {
            $days = null;
        }

        return [
            'id' => $this->id,
            'photo' => url(asset('storage/' . $this->photo)),
            'fullname' => $this->last_name . ' ' . $this->first_name . ' ' . $this->middle_name,
            'date' => optional($pass_date2)->format('Y-m-d'),
            'days' => $days
        ];
    }
}

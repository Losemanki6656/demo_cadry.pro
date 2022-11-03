<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Vacation;

class DepartmentCadryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if($this->staff_status == 0) $status = "Asosiy"; else $status = "O'rindosh";
        
        $status_vacation = Vacation::where('cadry_id',$this->cadry->id)
            ->where('status', true)
            ->whereDate( 'date2' , '>=' , now() )->first();
        
        if($status_vacation) {
            if($status_vacation->status_decret == true) $st = 2;
             else
             $st = 1;
        } else $st = 3;

        return [
            'id' => $this->id,
            'cadry' => [
                'id' => $this->cadry->id,
                'fullname' => $this->cadry->last_name .' ' . $this->cadry->first_name . ' ' . $this->cadry->middle_name,
                'photo' => url(asset('storage/' . $this->cadry->photo)),
            ],
            'department_id' => [
                'id' => $this->department->id,
                'name' => $this->department->name
            ],
            'staff_full' => $this->staff_full,
            'staff_date' => $this->staff_date,
            'rate' => $this->stavka,
            'staff_status' => $status,
            'status_sv' => $this->status_sv,
            'status_decret' => $this->status_decret,
            'status_fdecret' => $this->status,
            'status_vacation' => $st
        ];
    }
}

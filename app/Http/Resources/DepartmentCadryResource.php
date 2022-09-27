<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

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
        return [
            'id' => $this->id,
            'cadry' => [
                'id' => $this->cadry->id,
                'fullname' => $this->cadry->last_name . $this->cadry->first_name . $this->cadry->middle_name,
                'photo' => url($this->cadry->photo),
            ],
            'staff_full' => $this->staff_full,
            'staff_date' => $this->staff_date,
            'rate' => $this->stavka,
            'staff_status' => $status,
            'status_sv' => $this->status_sv,
            'status_decret' => $this->status_decret,
            'status_fdecret' => $this->status
        ];
    }
}

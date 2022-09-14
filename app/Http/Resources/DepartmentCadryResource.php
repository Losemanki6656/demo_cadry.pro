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
            'staff_full' => $this->staff_full,
            'staff_date' => $this->staff_date,
            'staff_status' => $status,
            'stavka' => $this->stavka,
        ];
    }
}

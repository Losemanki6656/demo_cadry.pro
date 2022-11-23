<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Vacation;
class ExcelOrgDepartmentCadryResource extends JsonResource
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
        
        $status_vacation = $this->cadry->vacationExport;
        
        if($status_vacation) {
            if($status_vacation->status_decret == true) $st = 2;
             else
             $st = 1;
        } else $st = 3;

        return [
            'id' => $this->id,
            'department' => $this->department->name,
            'staff_full' => $this->staff_full,
            'staff_date' => $this->staff_date,
            'category' => $this->staff->category->name,
            'rate' => $this->stavka,
            'staff_status' => $status,
            'status_sv' => $this->status_sv,
            'status_decret' => $this->status_decret,
            'status_fdecret' => $this->status,
            'status_vacation' => $st
        ];
    }
}

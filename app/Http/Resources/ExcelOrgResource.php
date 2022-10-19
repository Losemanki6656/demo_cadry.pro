<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ExcelOrgResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if($this->sex == true) $sex = "Erkak"; else $sex = "Ayol";
        return [
            'id' => $this->id,
            'photo' => url(asset('storage/' . $this->photo)),
            'fullname' => $this->last_name . ' ' . $this->first_name . ' ' . $this->middle_name,
            'department' => $this->department->name,
            'education' => $this->education->name,
            'birth_position' => $this->birth_region->name . ', ' . $this->birth_city->name,
            'now_position' => $this->address_region->name . ', ' . $this->address_city->name,
            'passport_position' => $this->pass_region->name . ', ' . $this->pass_city->name,
            'passport' => $this->passport,
            'passport_date' => $this->pass_date,
            'pinfl' => $this->jshshir,
            'nationality' => $this->nationality->name,
            'party' => $this->party->name,
            'sex' => $sex,
            'department_and_staffs' =>  ExcelOrgDepartmentCadryResource::collection($this->allStaffs),
            'instituts' =>  InstitutResource::collection($this->instituts),
        ];
    }
}

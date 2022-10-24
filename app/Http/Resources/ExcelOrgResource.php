<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Models\Language;
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
        $languages = Language::whereIn('id', explode(',',$this->language))->get();

        return [
            'id' => $this->id,
            'photo' => url(asset('storage/' . $this->photo)),
            'fullname' => $this->last_name . ' ' . $this->first_name . ' ' . $this->middle_name,
            'phone' => $this->phone,
            'department' => $this->department->name,
            'education' => $this->education->name,
            'birth_region' => $this->birth_region->name,
            'birth_city' => $this->birth_city->name,
            'now_position_region' => $this->address_region->name,
            'now_position_city' => $this->address_city->name,
            'passport_position_region' => $this->pass_region->name,
            'passport_position_city' => $this->pass_city->name,
            'passport' => $this->passport,
            'passport_date' => $this->pass_date,
            'pinfl' => $this->jshshir,
            'job_date' => $this->job_date,
            'academic_title' => $this->cadry_title->name,
            'academic_degree' => $this->cadry_degree->name,
            'work_level' => $this->work_level->name,
            'military_rank' => $this->military_rank,
            'deputy' => $this->deputy,
            'nationality' => $this->nationality->name,
            'party' => $this->party->name,
            'languages' => LanguageResource::collection($languages),
            'incentives' => IncentiveResource::collection($this->incentives),
            'discips' => DisciplinaryActionResource::collection($this->discips),
            'sex' => $sex,
            'department_and_staffs' =>  ExcelOrgDepartmentCadryResource::collection($this->allStaffs),
            'instituts' =>  InstitutResource::collection($this->instituts),
        ];
    }
}

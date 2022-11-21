<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Language;

class CadryEditResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if(count($this->allstaffs->where('staff_status',false)) > 0 )
            $post_name = $this->allstaffs->where('staff_status',false)->first();
        else 
            $post_name = $this->allstaffs->first();
        $languages = Language::whereIn('id', explode(',',$this->language))->get();
        
        return [
            'id' => $this->id,
            'photo' => url(asset('storage/' . $this->photo)),
            'last_name' => $this->last_name,
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'birth_date' => $this->birht_date,
            'birth_region_id' => new RegionResource($this->birth_region),
            'birth_city_id' => new CityResource($this->birth_city),
            'address_region_id' => new RegionResource($this->address_region),
            'address_city_id' =>  new CityResource($this->address_city),
            'address' =>  $this->address,
            'pass_region_id' =>  new RegionResource($this->pass_region),
            'pass_city_id' =>   new CityResource($this->pass_city),
            'pass_date' =>  $this->pass_date,
            'passport' =>  $this->passport,
            'jshshir' =>  $this->jshshir,
            'sex' =>  $this->sex,
            'phone' =>  $this->phone,
            'order' =>  $this->order,
            'status_dec' =>  $this->status_dec,
            'worklevel_id' => new WorklevelResource($this->work_level),
            'job_date' =>  $this->job_date,
            'allStaffs' =>  DepartmentCadryResource::collection($this->allstaffs)
        ];
    }
}

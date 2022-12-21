<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrganizationCadryResource extends JsonResource
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
        $vacation = null;
        if($this->vacation)
        if($this->vacation->date2 > now()) $vacation = new VacationResource($this->vacation);

        return [
            'id' => $this->id,
            'photo' => url(asset('storage/' . $this->photo)),
            'fullname' => $this->last_name . ' ' . $this->first_name . ' ' . $this->middle_name,
            'birth_date' => $this->birht_date,
            'staff' => new DepartmentCadryResource($post_name),
            'vacation' => $vacation,
            'phone' => $this->phone,
            'department' => $this->department->name,
            'organization_id' => $this->organization,
            'passport' => $this->passport,
            'passport_date' => $this->pass_date,
            'sex' => $this->sex,
            'order' => $this->order,
            'status_dec' => $this->status_dec,
            'full_birth_address' => $this->birth_region->name . ', ' . $this->birth_city->name,
            'full_live_address' => $this->address_region->name ?? '' . ', ' . $this->address_city->name ?? ''
        ];
    }
}

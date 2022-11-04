<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class CadryResource extends JsonResource
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

        return [
            'id' => $this->id,
            'photo' => url(asset('storage/' . $this->photo)),
            'fullname' => $this->last_name . ' ' . $this->first_name . ' ' . $this->middle_name,
            'birth_date' => $this->birht_date,
            'cadry_age' => Carbon::parse($this->birht_date)->age,
            'organization' => new OrganizationResource($this->organization),
            'staff' => new DepartmentCadryResource($post_name),
        ];
    }
}

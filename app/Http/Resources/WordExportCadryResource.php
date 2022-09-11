<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WordExportCadryResource extends JsonResource
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
            'birth_place' => $this->birth_region->name . ' ' . $this->birth_city->name,
            'staff' => new DepartmentCadryResource($post_name),
            'military_rank' => $this->military_rank,
            'deputy' => $this->deputy,
            'academec_degree' => $this->cadry_degree->name ?? '',
            'academec_title' => $this->cadry_title->name ?? '',
        ];
    }
}

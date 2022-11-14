<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\DepartmentCadry;

class CadryMedResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $cadry = DepartmentCadry::where('cadry_id', $this->cadry_id);

        if($cadry->where('staff_status',false)->count() > 0 )
            $post_name = $cadry->where('staff_status',false)->first();
        else 
            $post_name = $cadry->first();

        return [
            'id' => $this->id,
            'photo' => url(asset('storage/' . $this->photo)),
            'fullname' => $this->last_name . ' ' . $this->first_name . ' ' . $this->middle_name,
            'organization' => new OrganizationResource($this->organization),
            'date1' => $this->date1,
            'date2' => $this->date2,
            'staff' => new DepartmentCadryResource($post_name)
        ];
    }
}

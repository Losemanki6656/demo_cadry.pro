<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DepartmentStaffResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'staff_id' => new StaffResource($this->staff),
            'organization_id' => new OrganizationResource($this->organization),
            'classification_id' => new ClassificationResource($this->classification),
            'staff_fullname' => $this->staff_full,
            'rate' => $this->stavka,
            'rate_sum' => (float)number_format($this->summ_stavka,2)
        ];
    }
}

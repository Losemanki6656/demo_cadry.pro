<?php

namespace App\Http\Resources;

use App\Models\DepartmentStaff;
use App\Models\Department;
use Illuminate\Http\Resources\Json\JsonResource;

class StaffOrgResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $ids = DepartmentStaff::where('staff_id', $this->id)->groupBy('department_id')->pluck('department_id')->toArray();
        $deps = Department::whereIn('id',$ids)->get();
        return [
            'id' => $this->id,
            'name' => $this->name,
            'category_id' => $this->category_id,
            'cadries_count' => $this->cadries->count(),
            'departments_count' => $deps->count(),
            'departments' => DepResource::collection($deps)
        ];
    }
}

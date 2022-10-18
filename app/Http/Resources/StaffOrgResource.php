<?php

namespace App\Http\Resources;

use App\Models\DepartmentStaff;
use App\Models\Department;
use App\Models\DepartmentCadry;
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
        $cadries_count = DepartmentCadry::where('staff_id', $this->id)->count();
        return [
            'id' => $this->id,
            'name' => $this->name,
            'category_id' => $this->category_id,
            'cadries_count' => $cadries_count,
            'departments_count' => $deps->count(),
            'departments' => DepResource::collection($deps)
        ];
    }
}

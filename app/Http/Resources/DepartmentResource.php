<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\DepartmentCadry;

class DepartmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $z = 0; $q = 0; $x = 0; $y = 0; $p = 0; $q = 0;
        foreach($this->departmentstaff as $staff) {
            $x = $staff->stavka; 
            $p = $p  + $x;
            $l = $staff->cadry->sum('stavka');
            $y = $staff->cadry->where('status',false)->sum('stavka');

            if($x>$l) $z = $z + $x - $l;
            if($x<$y) $q = $q + $y - $x;
        }
        $cadries_count = DepartmentCadry::where('department_id',$this->id)->select('cadry_id')->groupBy('cadry_id')->get()->count();

        return [
            'id' => $this->id,
            'name' => $this->name,
            'vakan' => $z,
            'sverx' => $q,
            'plan' => $p,
            'cadries_count' => $cadries_count
        ];
    }
}

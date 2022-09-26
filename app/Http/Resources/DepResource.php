<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DepResource extends JsonResource
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
            $x = $staff->stavka; $p = $p  + $x;
            $l = $staff->cadry->sum('stavka');
            $y = $staff->cadry->where('status',false)->sum('stavka');
            
            if($x>$l) $z = $z + $x - $l;
            if($x<$y) $q = $q + $y - $x;
        }
        
        $a[$item->id] = $z;
        $b[$item->id] = $q;
        $all = $all + $z;
        $allSv =  $allSv + $q;
        $plan[$item->id] = $p;

        return [
            'id' => $this->id,
            'name' => $this->name,
            'a' => $request->a
        ];
    }
}

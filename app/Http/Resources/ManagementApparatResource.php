<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ManagementApparatResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if($this->type_qualification_id == 1) 
        
        $tq =  [
            'id' => 1,
            'name' => "Malaka oshirish"
        ];
         else
         $tq =  [
            'id' => 2,
            'name' => "Qayta topshirish"
        ];

        return [
            'id' => $this->id,
            'type_qualification' => $tq,
            'name' => $this->name,
            'directions' => $this->directions->count(),
        ];
    }
}

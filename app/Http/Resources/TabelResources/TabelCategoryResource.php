<?php

namespace App\Http\Resources\TabelResources;

use Illuminate\Http\Resources\Json\JsonResource;

class TabelCategoryResource extends JsonResource
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
            'name' => $this->name,
            'fullname' => '('.$this->category_code. '-'. $this->name. ') ' . $this->fullname,
            'category_code' => $this->category_code,
            'work_time' => $this->work_time,
        ];
    }
}

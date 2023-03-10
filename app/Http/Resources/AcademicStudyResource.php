<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AcademicStudyResource extends JsonResource
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
            'cadry_id' => $this->cadry_id,
            'date1' => $this->date1,
            'date2' => $this->date2,
            'academic_id' => new AcademicResource($this->academicname),
        ];
    }
}

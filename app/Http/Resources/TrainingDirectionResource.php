<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TrainingDirectionResource extends JsonResource
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
            'apparat' => new ApparatResource($this->apparat),
            'staff_name' => $this->staff_name,
            'time_lesson' => $this->time_lesson,
            'comment_time' => $this->comment_time
        ];
    }
}

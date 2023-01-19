<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CadryUpgradesResource extends JsonResource
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
            'data_qual' => $this->dataqual,
            'cadry' => new CadryResource($this->cadry),
            'apparat' => new ApparatResource($this->apparat),
            'training_direction' => new TrainingDirectionResource($this->training_direction)
        ];
    }
}

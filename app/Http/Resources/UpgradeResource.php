<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UpgradeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $directions = $this->apparat->directions;

        if ($this->type_training == 1)
        $type_qualification = [
            'id' => 1,
            'name' => "Malaka oshirish"
        ];  
            else  
        $type_qualification = [
            'id' => 2,
            'name' => "Qayta topshirish"
        ];

        if ($this->status == true)
        $status = [
            'status' => true,
            'message' => "Amalda"
        ];  
            else  
        $status = [
            'status' => false,
            'message' => "Tugatilgan"
        ];

        return [
            'id' => $this->id,
            'apparat' => new ApparatResource($this->apparat),
            'type_qualification' => $type_qualification,
            'training_direction' => new TrainingDirectionResource($this->training_direction),
            'data_qualification' => $this->dataqual,
            'status_bedroom' => $this->status_bedroom,
            'address' => $this->address,
            'comment' => $this->comment,
            'status' => $status,
            'status_training' => $this->status_training,
            'file_path' => $this->file_path,
            'type_test' => $this->type_test,
            'ball' => $this->ball,
            'directions' => $directions

        ];
    }
}

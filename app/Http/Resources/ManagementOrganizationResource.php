<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ManagementOrganizationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $upgrades = $this->upgrades;
        $bedroom = $this->upgrades->where('status_bedroom', false);
        $accepted = $this->upgrades->where('status_training', true);

        return [
            'id' => $this->id,
            'name' => $this->name,
            'upgrades' => $this->upgrades->count(),
            'status_bedroom' => $bedroom->count(),
            'accepteds' => $accepted->count()
        ];
    }
}

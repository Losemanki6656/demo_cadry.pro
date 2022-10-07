<?php

namespace App\Http\Resources;
use App\Models\DemoCadry;

use Illuminate\Http\Resources\Json\JsonResource;

class ArchiveCadryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $demo = DemoCadry::where('cadry_id',$this->id)->latest()->first();
        return [
            'id' => $this->id,
            'photo' => url(asset('storage/' . $this->photo)),
            'fullname' => $this->last_name . ' ' . $this->first_name . ' ' . $this->middle_name,
            'staff_full' => $this->post_name,
            'organization' => $this->organization->name,
            'command_number' => $demo->number,
            'comment' => $demo->comment
        ];
    }
}

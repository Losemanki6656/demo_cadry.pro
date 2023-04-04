<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ViewSlugResource extends JsonResource
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
            'photo' => url(asset('storage/' . $this->photo)),
            'fullname' => $this->last_name . ' ' . $this->first_name . ' ' . $this->middle_name,
            'phone' => $this->phone,
            'birth_date' => $this->birht_date,
            'birth_region' => $this->birth_region->name,
            'birth_city' => $this->birth_city->name,
            'pass_region' => $this->pass_region->name,
            'pass_city' => $this->pass_city->name,
            'address_region' => $this->address_region->name,
            'address_city' => $this->address_city->name,
            'passport' => $this->passport,
            'gmail' => $this->gmail,
            'pinfl' => $this->jshshir,
            'birth_place' => $this->birth_region->name . ' ' . $this->birth_city->name,
            'military_rank' => $this->military_rank,
            'deputy' => $this->deputy,
            'academec_degree' => $this->cadry_degree->name ?? '',
            'academec_title' => $this->cadry_title->name ?? '',
            'nationality' => $this->nationality->name ?? '',
            'party' => $this->party->name,
            'education' => $this->education->name,
        ];
    }
}

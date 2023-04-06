<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserEventLogResource extends JsonResource
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
            'user_id' => $this->user_id,
            'fullname' => $this->name,
            'email' => $this->email,
            'browser' => $this->browser,
            'version' => $this->version,
            'platform' => $this->platform,
            'ipAddress' => $this->ipAddress,
            'countryName' =>  $this->countryName,
            'countryCode' => $this->countryCode,
            'regionCode' => $this->regionCode,
            'regionName' => $this->regionName,
            'cityName' => $this->cityName,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'areaCode' => $this->areaCode,
            'timezone' => $this->timezone,
            'device' => $this->device,
            'status' => true
        ];
    }
}

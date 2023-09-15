<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VaccResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $type = "";
        if($this->status_decret == 0) $type = "Mehnat ta'tili";
        if($this->status_decret == 1) $type = "Bola parvarishlash ta'tili";
        if($this->status_decret == 2) $type = "Xomiladorlik va tug'ish ta'tili";
        if($this->status_decret == 3) $type = "Ish haqi saqlanmaydigan ta'til";
        if($this->status_decret == 4) $type = "Ish haqi qisman saqlanadigan ta'til";
        if($this->status_decret == 5) $type = "O'quv ta'tili";
        if($this->status_decret == 6) $type = "Ijodiy ta'tili";
        if($this->status_decret == 7) $type = "Kasallik ta'tili";
        return [
            'id' => $this->id,
            'date1' => $this->date1,
            'date2' => $this->date2,
            'status_decret' => $type,
            'command_number' => $this->command_number,
            'period1' => $this->period1,
            'period2' => $this->period2,
        ];
    }
}

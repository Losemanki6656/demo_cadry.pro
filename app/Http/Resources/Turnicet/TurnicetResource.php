<?php

namespace App\Http\Resources\Turnicet;

use Illuminate\Http\Resources\Json\JsonResource;

class TurnicetResource extends JsonResource
{

    public function toArray($request)
    {

        if ($this->Direction === 'in') {
            $status = 'IN';
        } else {
            $status = 'OUT';
        }

        return [
            'id' => $this->id,
            'name' => $this->FirstName . ' ' . $this->LastName . ' (' . $this->PersonGroup . ')',
            'status' => $status,
            'deviceName' => $this->PersonGroup,
            'date' => $this->AccessDate,
            'time' => $this->AccessTime,
        ];
    }
}

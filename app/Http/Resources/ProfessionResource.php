<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Models\Technical;

class ProfessionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $a = [];
        $technicals = Technical::get();

        foreach ( $technicals as $tech)
        {
            $status = false;

            foreach ( $this->technicals as $item)
            {
                if($item->id == $tech->id) {
                    $status = true;
                    break;
                }
            }

                $a[] = [
                    'id' => $tech->id,
                    'name' => $tech->name,
                    'status' => $status
                ];

        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'technicals' => $a

        ];
    }
}

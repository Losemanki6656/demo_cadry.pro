<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmmatCadry extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $cadry = $this->cadry;

        if(count($cadry->allstaffs->where('staff_status',false)) > 0 )
            $post_name = $cadry->allstaffs->where('staff_status',false)->first()->staff_full;
        else  
            if(count($cadry->allstaffs) > 0 )
                $post_name = $cadry->allstaffs->first()->staff_full;
        else $post_name = "";

        if($this->token_bio == null) $status = false; else $status = true;

        return [
            'id' => $this->id,
            'cadry_id' => $cadry->id,
            'photo' => url(asset('storage/' . $cadry->photo)),
            'fullname' => $cadry->last_name . ' ' . $cadry->first_name . ' ' . $cadry->middle_name,
            'staff_full' => $post_name,
            'status' => $status,
            'token_bio' => $this->token_bio
        ];
    }
}

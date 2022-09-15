<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Language;

class CadryInfoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $languages = Language::whereIn('id', explode(',',$this->language))->get();
        return [
            'id' => $this->id,
            'academictitle_id' => new AcademicTitleResource($this->cadry_title),
            'academicdegree_id' => new AcademicDegreeResource($this->cadry_degree),
            'nationality_id' => new NationalityResource($this->nationality),
            'education_id' => new EducationResource($this->education),
            'party_id' => new PartyResource($this->party),
            'languages' => LanguageResource::collection($languages),
            'military_rank' => $this->military_rank,
            'deputy' => $this->deputy
        ];
    }
}

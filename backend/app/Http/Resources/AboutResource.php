<?php

namespace App\Http\Resources;

use App\Models\Partner;
use Illuminate\Http\Resources\Json\JsonResource;

class AboutResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $partners = Partner::all();
        return [
            'hero_title' => $this->hero_title,
            'hero_image' => $this->hero_image,
            'about_title' => $this->about_title,
            'about_desc' => $this->about_desc,
            'vision_title' => $this->vision_title,
            'vision_desc' => $this->vision_desc,
            'mission_title' => $this->mission_title,
            'mission_lists' => $this->missionLists->pluck('name')->toArray(),
            'value_title' => $this->value_title,
            'value_subtitle' => $this->value_subtitle,
            'value_lists' => $this->valueLists->map(function ($valueList) {
                return [
                    'id' => $valueList->id,
                    'title' => $valueList->title,
                    'desc' => $valueList->desc,
                ];
            }),
            'part_cert_title' => $this->part_cert_title,
            'part_cert_desc' => $this->part_cert_desc,
            'partnership_title' => $this->partnership_title,
            'partner_list' => $partners->map(function ($partner) {
                return [
                    'id' => $partner->id,
                    'image' => $partner->image
                ];
            })->chunk(12)->toArray(),
            'certificate_title' => $this->certification_title,
            'certificate_list' => $this->certificate_list->map(function ($certificate) {

                return [
                    'id' => $certificate->id,
                    'image' => $certificate->image,
                    'title' => $certificate->title,
                    'company' => $certificate->company,
                    'published' => $certificate->created_at

                        ];
                    })->chunk(6)->toArray(),    
        ];
    }
}

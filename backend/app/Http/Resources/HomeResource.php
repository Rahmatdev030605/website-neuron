<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HomeResource extends JsonResource
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
            'hero'=>[
                'hero_title' => $this->heroTitleLists->map(function ($titleList) {
                    return [
                        'id' => $titleList->id,
                        'hero_title' => $titleList->hero_title,
                        'hero_desc' => $titleList->hero_desc,
                    ];
                }),
                'hero_image'=>$this->hero_image,
            ],
            'about' => [
                'about_title' => $this->about_title,
                'about_desc' => $this->about_desc,
            ],
            'program' => [
                'id' => $this->neuron_program_id,
                'title' => optional($this->neuronProgram)->title,
                'desc' => optional($this->neuronProgram)->desc,
                'ytEmbed' => optional($this->neuronProgram)->video,
                'tagline' => optional($this->neuronProgram)->tagline,
            ],
            'service' => [
                'service_title' => $this->service_title,
                'service_desc' => $this->service_desc,
            ],
            'partner' => [
                'partner_title' => $this->partner_title,
                'partner_desc' => $this->partner_desc,
                'partners' => $this->partners->map(function ($partner){
                    return [
                        'id' => $partner->id,
                        'image' => $partner->image
                    ];
                })->chunk(15)->toArray(),
            ],
            'testimonials' => $this->testimonials->map(function ($testimonial) {
                return [
                    'id' => $testimonial->id,
                    'desc' => $testimonial->desc,
                    'name' => $testimonial->name,
                    'star' => $testimonial->star,
                    'job' => $testimonial->job,
                    'image' => $testimonial->image,
                ];
          }),
            'article' => [
                'article_title' => $this->article_title,
                'article_desc' => $this->article_desc,
            ],
        ];
    }
}

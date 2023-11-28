<?php

namespace App\Http\Resources;

use App\Models\Article;
use App\Models\Service;
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
        $services = Service::all();
        $article = Article::all()->take(4);
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
                'title' => optional($this->neuronPrograms)->title,
                'desc' => optional($this->neuronPrograms)->desc,
                'ytEmbed' => optional($this->neuronPrograms)->video,
                'tagline' => optional($this->neuronPrograms)->tagline,
            ],
            'service' => [
                'service_title' => $this->service_title,
                'service_desc' => $this->service_desc,
                'neuron_services'=> $services->map(function ($service){
                    return [
                        'id' => $service->id,
                        'name' => $service->name,
                        'desc' => $service->desc,
                        'image' => $service->image,
                    ];
                })
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
                'neuron_articles' => $article->map(function ($blog){
                    return [
                        'id'=>$blog->id,
                        'title'=>$blog->title,
                        'image'=>$blog->image,
                        'created_at'=>$blog->created_at
                    ];
                })
            ],
        ];
    }
}

<?php

namespace App\Http\Resources;

use App\Models\Service;
use Illuminate\Http\Resources\Json\JsonResource;

class ServicePageResource extends JsonResource
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
            'name' =>$this->name,
            'desc' => $this->desc,
            'portofolio' => $this->portofolio->map(function ($portofolio){
                return [
                    'name'=>$portofolio->name,
                    'customer_name' => $portofolio->customer_name,
                    'desc' => $portofolio->desc,
                    'category' => $portofolio->category,
                    'image' => $portofolio->image,
                    'link' => $portofolio->link,
                    'our_solution' => $portofolio->our_solution,
                    'details' => $portofolio->details,
                    'created_at' => $portofolio->created_at,
                    'successProject'=>$portofolio->successProject,
                    'service_name'=>$portofolio->service->name,
                    'service_id'=>$portofolio->service_id
                ];
            }),
        ];
    }
}

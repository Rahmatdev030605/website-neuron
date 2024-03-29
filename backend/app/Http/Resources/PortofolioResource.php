<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PortofolioResource extends JsonResource
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
            'name' => $this->name,
            'customer_name' => $this->customer_name,
            'desc' => $this->desc,
            'link' => $this->link,
            'image' => $this->image,
            'our_solution' => $this->our_solution,
            'details' => $this->details,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'service_name' => $this->service->name,
            'service_id' => $this->service->id,
        ];
    }
}

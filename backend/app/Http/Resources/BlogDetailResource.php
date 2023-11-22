<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BlogDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $userName = $this->user->firstname . ' ' . $this->user->lastname;

        return [
            'id' => $this->id,
            'title' => $this->title,
            'image' => $this->image,
            'description' => $this->desc,
            'body' => $this->body,
            'author' => $this->author,
            'user' => $userName,
            'category' => $this->articleCategoryGroup->map(function ($category){
                return [
                    'id' => $category->articleCategory->id,
                    'name' => $category->articleCategory->name,
                ];
            }),
            'created_at' => $this->created_at->format('Y-m-d'),
            'updated_at' => $this->updated_at->format('Y-m-d'),
        ];
    }
}

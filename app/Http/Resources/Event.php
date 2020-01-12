<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Event extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'creator_id' => $this->creator_id,
            'creator_email' => $this->creator_email,
            'name' => $this->name,
            'description' => $this->description,
            'categories' => $this->categories()->get()->map(function($category){ return ['id' => $category->id, 'name' => $category->name];}),
            'tags' => $this->tags()->get()->map(function($tag){ return ['id' => $tag->id, 'name' => $tag->name];}) 
        ];

    }
}

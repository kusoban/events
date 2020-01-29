<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

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
        $user = auth()->user();
        $isFavorite = false;
        $isRegisteredTo = false;
        
        if($user) {
            $isFavorite = $this->usersWhoFavorited->contains($user->id);
            $isRegisteredTo = $this->usersWhoRegistered->contains($user->id);
        }

        return [
            'id' => $this->id,
            'creator_id' => $this->creator_id,
            'creator_email' => $this->creator_email,
            'name' => $this->name,
            'starts_at' => $this->starts_at,
            'description' => $this->description,
            'categories' => $this->categories()->get()->map(function($category){ return ['id' => $category->id, 'name' => $category->name];}),
            'tags' => $this->tags()->get()->map(function($tag){ return ['id' => $tag->id, 'name' => $tag->name];}),
            'isFavorite' => $isFavorite,
            'isRegisteredTo' => $isRegisteredTo,
            'location' => ['lat' => $this->location_lat, 'lng' => $this->location_lng],
            'humanDiff' =>  Carbon::createFromDate($this->starts_at)->diffForHumans(Carbon::now()),
        ];

    }
}

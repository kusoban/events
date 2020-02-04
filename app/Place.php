<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    protected $fillable = ['name', 'owner_id', 'address', 'description', 'location_lat', 'location_lng'];

    public function owner() {
        return $this->belongsTo(User::class);
    }

    public function types() {
        return $this->belongsToMany(PlaceType::class, 'place_type_pivot');
    }

    public function events() {
        return $this->hasMany(Event::class);
    }

    public function attachEvents($events) {
        foreach($events as $eventId) {
            $event = isset($eventId->name) ? Event::find($eventId->id) : Event::find($eventId);
            $userIsCreatorOfTheEvent = auth()->id() == $event->creator_id;

            if(!$event || !$userIsCreatorOfTheEvent || $this->events->contains($event)) continue;
            
            $this->events()->save($event);
        }
    }

    public function attachTypes($placeTypes) {
        foreach($placeTypes as $placeTypeId) {
            $placeType = PlaceType::find($placeTypeId);
            $userIsOwnerOfPlace = auth()->id() == $this->owner_id;

            if(!$placeType || !$userIsOwnerOfPlace || $this->types->contains($placeType)) continue;

            $this->types()->attach($placeType);
        }
    }

    public function attachCategories($categories) {
        foreach($categories as $categoryId) {
            $category = Category::find($categoryId);

            $userIsOwnerOfPlace = auth()->id() == $this->owner_id;

            if(!$category || !$userIsOwnerOfPlace) continue;

            $this->types()->attach($category);
        }
    }

}

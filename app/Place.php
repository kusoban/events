<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    protected $fillable = ['name', 'owner_id', 'address'];

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
            $event = Event::find($eventId);
            $userIsCreatorOfTheEvent = auth()->id() == $event->creator_id;

            if(!$event || !$userIsCreatorOfTheEvent) continue;

            $this->events()->save($event);
        }
    }

    public function attachTypes($placeTypes) {
        foreach($placeTypes as $placeTypeId) {
            $placeType = PlaceType::find($placeTypeId);
            $userIsOwnerOfPlace = auth()->id() == $this->owner_id;

            if(!$placeType || !$userIsOwnerOfPlace) continue;

            $this->types()->attach($placeType);
        }
    }

}

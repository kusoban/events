<?php

namespace App;

use App\Place;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    
    protected $fillable = ['name', 'description', 'image', 'creator_id', 'creator_email', 'starts_at', 'location_lat', 'location_lng', 'isPrivate'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function place() {
        return $this->belongsTo('App\Place');
    }

    public function tags() {
        return  $this->belongsToMany(Tag::class);
    }

    public function categories() {
        return $this->belongsToMany(Category::class);
    }
    
    public function usersWhoFavorited() {
        return $this->belongsToMany(User::class, 'favorite_event_user');
    }
    
    public function usersWhoRegistered() {
        return $this->belongsToMany(User::class, 'registered_event_user');
    }

    public function attachToPlace($userId, $placeId) {
        $place = Place::find($placeId);
        if(!$place) return;

        if ($userId != $place->owner_id) return;

        $place->events()->save($this);
    }

    public function addCategories($categories) {
        foreach ($categories as $categoryId) {
                $foundCategory = Category::find($categoryId);
                
                if($foundCategory) {
                    $this->categories()->attach($foundCategory);
                    continue;
                }
        }
    }

    public function addTags($tags) {
        foreach ($tags as $tagName) {
                $foundTag = Tag::where('name', $tagName)->first();
                
                if($foundTag) {
                    $this->tags()->attach($foundTag);
                    continue;
                }

                $this->tags()->attach(Tag::create(['name' => $tagName]));
        }
    }
}

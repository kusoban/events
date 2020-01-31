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

}

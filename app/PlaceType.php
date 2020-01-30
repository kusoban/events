<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlaceType extends Model
{
    public function places() {
        return $this->belongsToMany(Place::class, 'place_type_pivot');
    }
}

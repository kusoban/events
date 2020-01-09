<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['name', 'description'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function tags() {
        return  $this->belongsToMany(Tag::class);
    }

    public function categories() {
        return $this->belongsToMany(Category::class);
    }
}

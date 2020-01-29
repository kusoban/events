<?php

use Illuminate\Database\Seeder;
use App\Event;
use App\Tag;
use App\Category;

class EventsTableSeeder extends Seeder 
{
    public function run () {
        factory(Event::class, 10000)->create();
        $categories = Category::all();
        $tags = Tag::all();

        Event::all()->each(function($event) use ($categories, $tags){
            $event->categories()->attach($categories->random(3)->pluck('id')->toArray());
            $event->tags()->attach($tags->random(7)->pluck('id')->toArray());
        });
    }
}
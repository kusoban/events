<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Event;
use App\Category;
use App\Tag;
use App\Http\Resources\CategoryEvents as CategoryEventsResource;

class SearchController extends Controller
{
    public function index() {
        $stext = request('search_text');
        return Event::where( function ( $q2 ) use ( $stext ) {
            $q2->whereRaw( 'LOWER(`name`) like ?', array( '%' . strtolower($stext) . '%' ) );
            $q2->orWhereRaw( 'LOWER(`description`) like ?', array( '%' . strtolower($stext) . '%' ) );
        })->paginate(16);
        
    }

    public function filter() {
        if(request()->has('category') && !empty(request()->category)) {
            $events = Event::whereHas('categories', function($q) {
                $q->where('name', request()->category);
            })->with(['categories', 'tags']);
        };

        if(request()->has('tag') && !empty(request()->tag)) {
            $tags = request('tags');
            $tagsArray = [$tags];

            if(stripos($tags, ',') >= 0) {
                $tagsArray = explode(',', $tags);
                $tagsArray = array_filter($tagsArray, 'is_numeric');
            }

            $events->whereHas('tags', function($q) use ($tagsArray) {
                $q->whereIn('name', $tagsArray);
            });
        }
        return $events->get();
    }

    public function category() {
        $category = Category::where('name', request()->name)->first();
        return new CategoryEventsResource($category);
    }
}

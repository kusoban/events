<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Event;
use App\Category;
use App\Tag;
use App\Http\Resources\Event as EventResource;
use Illuminate\Support\Carbon;

class SearchController extends Controller
{
    public function index() {
        $stext = request('search_text');
        return EventResource::collection(Event::where( function ( $q2 ) use ( $stext ) {
            $q2->whereRaw( 'LOWER(`name`) like ?', array( '%' . strtolower($stext) . '%' ) );
            $q2->orWhereRaw( 'LOWER(`description`) like ?', array( '%' . strtolower($stext) . '%' ) );
        })->orderBy('starts_at', 'desc')
        ->paginate(15)
        ->appends(['search_text' => request('search_text') ?? '']));

    }

    public function filter() {
        $stext = request('text');
        $result = Event::where( function ( $q2 ) use ( $stext ) {
            $q2->whereRaw( 'LOWER(`name`) like ?', array( '%' . strtolower($stext) . '%' ) );
            $q2->orWhereRaw( 'LOWER(`description`) like ?', array( '%' . strtolower($stext) . '%' ) );
        });
        
        if(request('starts_at_from')) {
            $result = $result
                ->where('starts_at', '>=', date(request('starts_at_from')));
        }

        if(request('starts_at_to')) {
            $result = $result
                ->where('starts_at', '<=', date(request('starts_at_to')));
        }

        if(request('categories')) {
            $result = $result->whereHas('categories', function($query) {
                $query->whereIn('id', request('categories'));
            });
        }
        
        if(request('tags')) {
            $result = $result->whereHas('tags', function($query) {
                $query->whereIn('id', request('tags'));
            });
        }

        $result = $result->orderBy('starts_at', 'asc')
            ->paginate(15)
            ->appends($_GET);

        $result = EventResource::collection($result);

        return $result;
    }

    public function category() {
        $category = Category::where('name', request('name'))->first();
        $events = $category->events()->whereDate('starts_at', '>=', Carbon::today())->paginate(15);
        return EventResource::collection($events);
    }
}

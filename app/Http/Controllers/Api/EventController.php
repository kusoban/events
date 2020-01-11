<?php

namespace App\Http\Controllers\Api;

use App\Event;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Tag;
use App\Category;

use App\Http\Resources\Event as EventResource;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = Event::latest()->get();

        return EventResource::collection($events);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        
        request()->validate([
            'name' => 'required|min:2',
            'description' => 'required|min:5'
        ]);

        $event = request()->all();
        $event['creator_id'] = $user->id;
        $event['creator_email'] = $user->email;

        $event = Event::create( $event );
      
        if(request()->categories) {
            $event->addCategories(request()->categories);
            
        }
        if(request()->tags) {
            $event->addTags(request()->tags);
        }

        return new EventResource($event);

    }

    /**
     * Display the specified resource.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        return new EventResource($event);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
       request()->validate([
            'name' => 'required|min:2',
            'description' => 'required|min:5'
        ]);

        $event->update(request()->all());
        return new EventResource($event);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        $event->delete();
        return response('success', 200);
    }

    public function search() {
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
}
<?php

namespace App\Http\Controllers\Api;

use App\Event;
use App\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Http\Resources\Event as EventResource;
use App\Http\Resources\Category as CategoryResource;
use Illuminate\Support\Carbon;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        auth()->shouldUse('api');
        $events = Event::whereDate('starts_at', '>=', Carbon::today())->orderBy('starts_at', 'asc')->paginate(16);
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
        request()->validate([
            'name' => 'required|min:2',
            'description' => 'required|min:5',
            'starts_at' => 'date'
        ]);

        $user = auth()->user();

        $event = [
            'name' => request('name'),
            'description' => request('description'),
            'starts_at' => date('Y-m-d H:i:s', strtotime(request('starts_at')))
        ];

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
        auth()->shouldUse('api');
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

    public function toggleRegister() {
        $user = auth()->user();
        $eventId = request('eventId');
        $event = Event::find($eventId);

        if(!$event) return response()->json('not found', 404);

        $user->registeredToEvents()->toggle($event);

        return response(['result' => 'success'], 200);
    }

    public function toggleFavorite() {
        $user = auth()->user();
        $eventId = request('eventId');
        $event = Event::find($eventId);

        if(!$event) return response()->json('not found', 404);

        $user->favoriteEvents()->toggle($event->id);

        return response(['result' => 'success'], 200);
    }

    public function getEventsUserIsRegisteredTo() {
        $user = auth()->user();
        $events = $user->registeredToEvents()->get();
        if(!$events) {
            return response()->json('nothing found', 404);
        }

        return response()->json($events, 200);
    }

    public function getFavoriteEvents() {
        $user = auth()->user();
        $events = $user->favoriteEvents()->get();

        return response()->json($events, 200);
    }

}
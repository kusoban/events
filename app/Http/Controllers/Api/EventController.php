<?php

namespace App\Http\Controllers\Api;

use App\Event;
use App\Place;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Resources\Place as PlaceResource;
use App\Http\Resources\Event as EventResource;
use Illuminate\Support\Carbon;

class EventController extends Controller
{

    function __construct() {
        $this->middleware('auth:api', ['except' => ['index', 'show', 'getRegisteredUsers', 'getEventPlace']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\
     */
    public function index()
    {
        auth()->shouldUse('api');
        $events = Event::whereDate('starts_at', '>=', Carbon::today())
            ->orderBy('starts_at', 'asc')
            ->with('tags')
            ->paginate(15);
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
            'starts_at' => date('Y-m-d H:i:s', strtotime(request('starts_at'))),
            'creator_id' => $user->id,
            'creator_email' => $user->email,
            'location_lat' => request('location_lat'),
            'location_lng' => request('location_lng'),
        ];


        $event = Event::create($event);

        if(request('place_id')) {
            $event->attachToPlace($user->id, request('place_id'));
        }

        $categories = request('categories');
        $tags = request('tags');
        
        if ($categories) {
            $event->addCategories($categories);
        }

        if ($tags) {
            $event->addTags($tags);
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

    public function toggleRegister()
    {
        $user = auth()->user();
        $eventId = request('eventId');
        $event = Event::find($eventId);

        if (!$event) return response()->json('not found', 404);

        $user->registeredToEvents()->toggle($event);
        return response(['result' => 'success'], 200);
    }

    public function toggleFavorite()
    {
        $user = auth()->user();
        $eventId = request('eventId');
        $event = Event::find($eventId);

        if (!$event) return response()->json('not found', 404);

        $user->favoriteEvents()->toggle($event->id);
        return response(['result' => 'success'], 200);
    }

    public function getEventsUserIsRegisteredTo()
    {
        $user = auth()->user();
        $events = $user->registeredToEvents()->get();

        if (!$events) {
            return response()->json('nothing found', 404);
        }

        return response()->json($events, 200);
    }

    public function getFavoriteEvents()
    {
        $user = auth()->user();
        $events = $user->favoriteEvents()->get();
        return EventResource::collection($events);
    }

    public function getRegisteredUsers(Event $event) {
        $users = $event->usersWhoRegistered()->get()->pluck('email');
        return $users;
    }

    public function getEventPlace(Event $event) {
        // return $event->place;
        return new PlaceResource($event->place);
    }
}

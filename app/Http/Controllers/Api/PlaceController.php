<?php

namespace App\Http\Controllers\Api;

use App\Place;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PlaceType;
use App\Http\Resources\Place as PlaceResource;
use App\Event;

class PlaceController extends Controller
{

    function __construct() {
        $this->middleware('auth:api', ['except' => ['index', 'show', 'getPlaceEvents']]);
    } 

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $places = Place::with('owner', 'types', 'events')->get();
        return PlaceResource::collection($places);
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
            'address' => 'required|min:3',
            'description' => 'required|min:5'
        ]);

        $place = Place::create([
            'owner_id' => auth()->user()->id, 
            'name' => request('name'),
            'address' => request('address'), 
            'description' => request('description'), 
            'location_lat' => request('location_lat'),
            'location_lng' => request('location_lng')
        ]);

        if(request('events')) {
            $place->attachEvents(request('events'));
        }

        if(request('types')) {
            $place->attachTypes(request('types'));
        }

        return new PlaceResource($place);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Place  $place
     * @return \Illuminate\Http\Response
     */
    public function show(Place $place)
    {
        return new PlaceResource($place);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Place  $place
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Place $place)
    {

        $place->update([
            'name' => request('name'),
            'address' => request('address'),
        ]);

        if(request('types')) {
            foreach(request('types') as $typeId) {
                if(PlaceType::find($typeId) && !$place->types->contains($typeId)) {
                    $place->types()->attach($typeId);
                }
            }
        }
        return new PlaceResource($place);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Place  $place
     * @return \Illuminate\Http\Response
     */
    public function destroy(Place $place)
    {
        //
    }

    public function attachEvent(Place $place, Event $event) {
        if($place->owner_id !== auth()->id() || $event->creator_id !== auth()->id()) {
            return response()->json('not authorized', 401);
        }

        $place->events()->save($event);

        return new PlaceResource($place);
    }

    public function getPlaceEvents(Place $place) {
        return $place->events()->orderBy('starts_at', 'asc')->get();
    }

}

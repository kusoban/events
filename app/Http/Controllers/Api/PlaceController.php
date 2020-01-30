<?php

namespace App\Http\Controllers\Api;

use App\Place;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Place as PlaceResource;
use App\Event;
class PlaceController extends Controller
{

    function __construct() {
        $this->middleware('api:auth', ['except' => ['index', 'show']]);
    } 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $place = Place::find(1);
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
        Place::create([
            'owner_id' => auth()->user()->id, 
            'name' => request('name'),
            'address' => request('address'), 
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Place  $place
     * @return \Illuminate\Http\Response
     */
    public function show(Place $place)
    {
        //
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
        //
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
}

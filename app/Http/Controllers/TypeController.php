<?php

namespace App\Http\Controllers;

use App\PlaceType;
use Illuminate\Http\Request;

class PlaceTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return PlaceType::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PlaceType  $placeType
     * @return \Illuminate\Http\Response
     */
    public function show(Placetype $placeType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PlaceType  $placeType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PlaceType $placeType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PlaceType  $placeType
     * @return \Illuminate\Http\Response
     */
    public function destroy(PlaceType $placeType)
    {
        //
    }
}

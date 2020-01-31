<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use App\Http\Resources\User as UserResource;
use App\Http\Resources\Place as PlaceResource;
use App\Http\Resources\Event as EventResource;


class UserController extends Controller
{
    function __construct() {
        $this->middleware('auth:api', ['only' => ['getUserPlaces', 'getUserEvents']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return $users;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
  public function store(Request $request)
    {

        $rules = [
            'name' => 'required',
            'email' => "required|email|unique:users",
            'password' => 'required|min:6|confirmed',
        ];

        $this->validate(request(), $rules);
        $data['name'] = request()->name;
        $data['email'] = request()->email;
        $data['password'] = bcrypt(request()->password);
        $data['verified'] = User::UNVERIFIED_USER;
        $data['verification_token'] = User::generateVerificationCode();
        $data['admin'] = User::REGULAR_USER;

        $user = User::create($data);

        return new UserResource($user);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }

    public function getUserPlaces() {
        return PlaceResource::collection(auth()->user()->places()->get());
    }

    public function getUserEvents() {
        return EventResource::collection(auth()->user()->events()->get());
    }
}


<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use App\Http\Resources\User as UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use GuzzleHttp\Client;


class AuthController extends Controller
{
    private static $grant_type = 'password';

    public function testreg(Request $request) {
        $http = new Client([ 'base_uri' => 'http://events.api/','timeout' => 0]);
        $response = $http->post('/oauth/token', [
            'form_params' => [
                'grant_type' => self::$grant_type,
                'username' => 'george@george323322.george',
                'password'=> '123123123',
                'client_id' => config('passport.client_id'),
                'client_secret' => config('passport.client_secret'),
                'scope' => '',
            ],
        ]);    
        return $response;
}

    public function register(Request $request) {
        $rules = [
            'name' => 'required',
            'email' => "required|email|unique:users",
            'password' => 'required|min:6|confirmed',
        ];

        $this->validate($request, $rules);

        $user = User::create([
            'email' => request('email'),
            'name' => request('name'),
            'password' => bcrypt($request->password),
            'verified' => User::UNVERIFIED_USER,
            'verification_token' => User::generateVerificationCode(),
            'admin' => User::REGULAR_USER,
        ]);

        $http = new Client([ 'base_uri' => 'http://events.api/','timeout' => 0]);
        
        $tokenResponse = $http->post('/oauth/token', [
            'form_params' => [
                'grant_type' => self::$grant_type,
                'username' => request()->email,
                'password'=> request()->password,
                'client_id' => config('passport.client_id'),
                'client_secret' => config('passport.client_secret'),
                'scope' => '',
            ],
        ]); 

        return response()->json([
            'user' => new UserResource($user),
            'token_data' => json_decode((string) $tokenResponse->getBody(), true),
        ], 200);
    }

    public function login(Request $request) {
        $auth = auth()->attempt(['email' => request()->email, 'password' => request()->password]);
        
        if(!$auth) {
            return response('Unauthenticated', 403);
        }

        $request->request->add([
            'grant_type' => self::$grant_type,
                'client_id' => config('passport.client_id'),
                'client_secret' => config('passport.client_secret'),
            'scope' => '',
        ]);
      
        $tokenRequest = Request::create('/oauth/token', 'POST');
        $result = json_decode(Route::dispatch($tokenRequest)->getContent());
        $result->email = auth()->user()->email;

        return response()->json($result, 200);
    }

    public function getAuthenticatedUser () {
        $user = auth()->user();
        return new UserResource($user);
    }
}

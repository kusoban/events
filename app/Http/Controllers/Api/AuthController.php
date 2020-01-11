<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use App\Http\Resources\User as UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Auth;
use GuzzleHttp\Client;

class AuthController extends Controller
{
    public function testreg(Request $request) {
        $http = new Client([ 'base_uri' => 'http://events.api/public/','timeout' => 0]);
        $response = $http->post('/oauth/token', [
            'form_params' => [
                'grant_type' => 'password',
                'username' => 'george@george323322.george',
                'password'=> '123123123',
                'client_id' => '2',
                'client_secret' => 'kHQNoMlGKBGr6tby2U6UW4xsRCZeQfqWhNSc3OQE',
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

        
        request()->request->add([
                'grant_type' => 'password',
                'username' => request()->email,
                'client_id' => 2,
                'client_secret' => 'kHQNoMlGKBGr6tby2U6UW4xsRCZeQfqWhNSc3OQE',
                'scope' => '',
        ]);

        $tokenRequest = Request::create('/oauth/token', 'POST');
        $tokenData = json_decode(Route::dispatch($tokenRequest)->getContent());

        return response()->json(['user' => new UserResource($user), 'token_data' => $tokenData, ], 200);
    }

    public function resetPassword() {
        $user = auth()->user();
    }

    public function login(Request $request) {
        $auth = auth()->attempt(['email' => request()->username, 'password' => request()->password]);
        
        if(!$auth) {
            return response('Unauthenticated', 403);
        }

        $request->request->add([
                'grant_type' => 'password',
                'client_id' => '4',
                'client_secret' => 'kHQNoMlGKBGr6tby2U6UW4xsRCZeQfqWhNSc3OQE',
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

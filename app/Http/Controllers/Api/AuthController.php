<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// use GuzzleHttp;
class AuthController extends Controller
{
    public function register(Request $request) {
        $email = request('email');
        $password = request('password');
        $user = User::create(['email' => $email, 'password' => bcrypt($password)]);
        
        $accessToken = $user->createToken('authToken')->accessToken;

        return response()->json(['email' => $user->email, 'token' => $accessToken], 200);
    }

    public function login(Request $request) {
        // $gRequest = $http->request('post', config('app.url') . ':8000' . '/oauth/token' );
        // return $gRequest;
        // $gRequest->
        // return config('app.url');
        $data = $request->request->add([
                'grant_type' => 'password',
                'client_id' => '4',
                'client_secret' => 'Az2gLVGdZoKf6ttCTAbsKo2Qv8DVxsFqtNa7447F',
                // 'username' => request('email'),
                // 'password' => request('password'),
                'scope' => '',
        ]);

        // return $request->all();
        $tokenRequest = Request::create(config('app.url') . '/oauth/token', 'POST');

        $response = Route::dispatch($tokenRequest);
        return $response;
        // $response = $http->post(config('app.url') . '/oauth/token', [
        //     'form_params' => [
        //     ],
        // ]);

        // return json_decode((string) $response->getBody(), true);
        // if(!auth()->attempt(['email' => request('email'), 'password' => request('password')])) {
        //     return response()->json('Wrong credentials', 403);
        // }

    }

    public function getAuthenticatedUser () {
        $user = auth()->user();
        return response()->json(['email'=> $user->email], 200);
    }
}

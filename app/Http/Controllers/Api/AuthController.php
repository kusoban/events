<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Auth;
class AuthController extends Controller
{
    public function register(Request $request) {
        $email = request('email');
        $password = request('password');
        $user = User::create(['email' => $email, 'password' => bcrypt($password)]);
        
        $accessToken = $user->createToken('authToken')->accessToken;

        return response()->json(['email' => $user->email, 'token' => $accessToken], 200);
    }

    public function resetPassword() {
        $user = auth()->user();
    }

    public function login(Request $request) {
        $auth = auth()->attempt(['email' => $request->username, 'password' => $request->password]);
        
        if(!$auth) {
            return response('Unauthenticated', 403);
        }

        $request->request->add([
                'grant_type' => 'password',
                'client_id' => '4',
                'client_secret' => 'Az2gLVGdZoKf6ttCTAbsKo2Qv8DVxsFqtNa7447F',
                'scope' => '',
        ]);

        $tokenRequest = Request::create('/oauth/token', 'POST');
        $result = json_decode(Route::dispatch($tokenRequest)->getContent());
        $result->email = auth()->user()->email;

        return response()->json($result, 200);
    }

    public function getAuthenticatedUser () {
        $user = auth()->user();
        return response()->json(['email'=> $user->email], 200);
    }
}

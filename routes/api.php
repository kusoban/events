<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', 'Api\AuthController@register');
Route::post('/login', 'Api\AuthController@login');
Route::middleware('auth:api')->post('me', 'Api\AuthController@getAuthenticatedUser');

Route::group(['prefix' => 'events'], function(){
    Route::get('/', 'Api\EventController@index');
    Route::get('/{id}', [ 'as' => 'show-event', 'uses' => 'Api\EventController@show']);

    Route::post('/', 'Api\EventController@store')->middleware('auth:api');
    // Route::post('/');
});

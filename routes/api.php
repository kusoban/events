<?php

use Illuminate\Http\Request;
// use Illuminate\Routing\Route;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/register', 'Api\AuthController@register');
Route::post('/login', 'Api\AuthController@login');
Route::middleware('auth:api')->post('/reset-password', 'Api\AuthController@resetPassword');

Route::middleware('auth:api')->post('me', 'Api\AuthController@getAuthenticatedUser');

Route::group(['prefix' => 'events'], function(){
    Route::get('/', 'Api\EventController@index');
    Route::get('/{event}', [ 'as' => 'show-event', 'uses' => 'Api\EventController@show']);
    Route::post('/', 'Api\EventController@store')->middleware('auth:api');
    Route::put('/{event}', 'Api\EventController@update')->middleware('auth:api');
    Route::delete('/{event}', 'Api\EventController@destroy')->middleware('auth:api');
});

Route::group(['prefix' => 'categories'], function() {
    Route::get('/', 'Api\CategoryController@index');
    Route::post('/', 'Api\CategoryController@store')->middleware('auth:api');
    Route::get('/{category}', 'Api\CategoryController@show');
    Route::put('/{category}', 'Api\CategoryController@update')->middleware('auth:api');
    Route::delete('/{category}', 'Api\CategoryController@destroy');
});

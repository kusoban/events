<?php

use Illuminate\Support\Facades\Route;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;

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
Route::post('/test', 'Api\MapController@test');

Route::post('/register', 'Api\AuthController@register');
Route::post('/login', 'Api\AuthController@login');
Route::middleware('auth:api')->post('/reset-password', 'Api\AuthController@resetPassword');

Route::middleware('auth:api')->get('me', 'Api\AuthController@getAuthenticatedUser');



Route::group(['prefix' => 'users'], function(){
    Route::get('/places', 'Api\UserController@getUserPlaces');
    Route::get('/events', 'Api\UserController@getUserEvents');
    Route::get('/', 'Api\UserController@index');
    Route::post('/', 'Api\UserController@store');
});

Route::group(['prefix' => 'events'], function(){
    Route::get('/my', 'Api\EventController@getMyEvents');
    Route::post('/register', 'Api\EventController@toggleRegister');
    Route::get('/registered', 'Api\EventController@getEventsUserIsRegisteredTo');
   
    Route::post('/favorites', 'Api\EventController@toggleFavorite');
    Route::get('/favorites', 'Api\EventController@getFavoriteEvents');
   
    Route::get('/', 'Api\EventController@index');
    Route::post('/', 'Api\EventController@store');
    Route::get('/{event}', [ 'as' => 'show-event', 'uses' => 'Api\EventController@show']);
    Route::put('/{event}', 'Api\EventController@update');
    Route::delete('/{event}', 'Api\EventController@destroy');
    
    Route::get('/{event}/place', 'Api\EventController@getEventPlace');
    Route::get('/{event}/registered-users', 'Api\EventController@getRegisteredUsers');
});

Route::group(['prefix' => 'categories'], function() {
    Route::get('/', 'Api\CategoryController@index');
    Route::post('/', 'Api\CategoryController@store')->middleware('auth:api');
    Route::get('/{category}', 'Api\CategoryController@show');
    Route::put('/{category}', 'Api\CategoryController@update')->middleware('auth:api');
    Route::delete('/{category}', 'Api\CategoryController@destroy');
});

Route::group(['prefix' => 'tags'], function() {
    Route::get('/', 'Api\TagController@index');
    Route::post('/', 'Api\TagController@store')->middleware('auth:api');
    Route::get('/{tag}', 'Api\TagController@show');
    Route::put('/{tag}', 'Api\TagController@update')->middleware('auth:api');
    Route::delete('/{tag}', 'Api\TagController@destroy');
});

Route::group(['prefix' => 'search'], function(){
    Route::get('/', 'Api\SearchController@index');
    Route::get('/filter', 'Api\SearchController@filter');
    Route::get('/category', 'Api\SearchController@category');
    Route::get('/places/types', 'Api\SearchController@getPlacesByTypes');
});

Route::group(['prefix' => 'places'], function() {
    Route::get('/my', 'Api\PlaceController@getMyPlaces');
    Route::post('/{place}/events/{event}', 'Api\PlaceController@attachEvent');
    Route::put('/{place}/events/{event}', 'Api\PlaceController@detachEvent');
    Route::get('/{place}/events', 'Api\PlaceController@getPlaceEvents');

});
Route::apiResource('places', 'Api\PlaceController');

Route::apiResource('place-types', 'Api\PlaceTypeController');


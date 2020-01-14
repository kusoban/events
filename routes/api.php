<?php

use Illuminate\Http\Request;
// use Illuminate\Routing\Route;
use Illuminate\Support\Facades\DB;
use App\Event;

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
Route::get('/', function() {
    return 'kek';
})->middleware('cors');

Route::post('/register', 'Api\AuthController@register');
Route::post('/test', 'Api\AuthController@test');
Route::post('/login', 'Api\AuthController@login');
Route::middleware('auth:api')->post('/reset-password', 'Api\AuthController@resetPassword');

Route::middleware('auth:api')->post('me', 'Api\AuthController@getAuthenticatedUser');

Route::group(['prefix' => 'search'], function(){
    Route::get('/', 'Api\SearchController@index');
    Route::get('/category', 'Api\SearchController@category');
});

Route::group(['prefix' => 'users'], function(){
    Route::get('/', 'Api\UserController@index');
    Route::post('/', 'Api\UserController@store');
});

Route::group(['prefix' => 'events'], function(){
    Route::get('/', 'Api\EventController@index');
    Route::get('/{event}', [ 'as' => 'show-event', 'uses' => 'Api\EventController@show']);
    Route::post('/', 'Api\EventController@store')->middleware('auth:api');
    Route::put('/{event}', 'Api\EventController@update')->middleware('auth:api');
    Route::delete('/{event}', 'Api\EventController@destroy')->middleware('auth:api');
    Route::get('/filter', 'Api\EventController@filter');
});

Route::group(['prefix' => 'categories'], function() {
    Route::get('/', 'Api\CategoryController@index');
    Route::post('/', 'Api\CategoryController@store')->middleware('auth:api');
    Route::get('/{category}', 'Api\CategoryController@show');
    Route::put('/{category}', 'Api\CategoryController@update')->middleware('auth:api');
    Route::delete('/{category}', 'Api\CategoryController@destroy');
});

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


Route::apiResource('hotels', 'HotelController');

Route::apiResource('rooms', 'RoomController');

Route::apiResource('clients', 'ClientController');
Route::put('client/insertRoom/{id}/{room_id}', 'ClientController@insertRoom');
Route::put('client/insertLecture/{id}/{lecture_id}', 'ClientController@insertLecture');
Route::get('client/getLectures/{id}', 'ClientController@getLectures');

Route::apiResource('lectures', 'LectureController');
Route::get('lecture/getClients/{id}', 'LectureController@getClients');


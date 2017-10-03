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

Route::post('/login', 'LoginController@loginApi');
Route::post('/register', 'LoginController@registerApi');
Route::post('/check-mac', 'LoginController@loginMac');
Route::post('/all/bus', 'BusApiController@getBuses');
Route::get('/get/bus', 'BusApiController@takeBus');
Route::post('/current/location', 'BusApiController@busCurrent');

Route::post('/checkip', 'ICOapiController@checkIp');
Route::get('/get/sections', 'ICOapiController@getSubj');
Route::post('/attendance', 'ICOapiController@attendance');
Route::post('/enroll/section', 'ICOapiController@enSect');
Route::get('/get/all/files', 'ICOapiController@getFiles');
Route::get('/get/quiz', 'ICOapiController@getQuiz');

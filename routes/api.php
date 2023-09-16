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
//
//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::post('/create_clientUser', 'ApiController@createClientUser');
Route::post('/update_clientUser', 'ApiController@updateClientUser');
Route::post('/delete_clientUser', 'ApiController@deleteClientUser');
Route::get('/login_status', 'ApiController@loginStatus');
Route::post('/createSecretkey', 'ApiController@createSecretKey');
Route::get('/user_logout', 'ApiController@logoutClient');


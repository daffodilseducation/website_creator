<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('website-home');
});
Auth::routes();


//Route::get('/login', 'LoginController@loginSso');
Route::get('/login/s', 'LoginController@login');

Route::post('/userlogin', 'LoginController@userLogin');
Route::get('/dashboard', 'LoginController@dashboard');
Route::get('/logout', 'LoginController@logout');

Route::get('/createDomain', 'DomainController@createDomain');
Route::post('/updateDomain', 'DomainController@postUpdateDomain');
Route::post('/createDomain', 'DomainController@postCreateDomain');
Route::get('/domain', 'DomainController@domain');
Route::get('/client-user', 'ClientUserController@clientUserList');
Route::get('/client-list', 'ClientUserController@clientList');
Route::get('/user/edit/{id}', 'ClientUserController@clientEdit');
Route::post('/updateUser', 'ClientUserController@postUpdateUser');
Route::get('/createUser', 'ClientUserController@createUser');
Route::post('/createPostUser', 'ClientUserController@createPostUser');
Route::get('/domainDetails/{id}', 'DomainController@domainDetails');
Route::get('/bulkUpload', 'ClientUserController@bulkUpload');
Route::get('/downloadSample', 'ClientUserController@downloadSample');
Route::post('/import_sheet', 'ClientUserController@importSheet');
Route::get('/domain/edit/{id}', 'DomainController@editDomain');


Route::get('/forget-password', 'ForgotPasswordController@getEmail');
Route::post('/forget-password', 'ForgotPasswordController@postEmail');
Route::get('/reset-password/{token}', 'ResetPasswordController@getPassword');
Route::post('/reset-password', 'ResetPasswordController@updatePassword');
Route::get('/logout/app', 'LoginController@logoutApp');

Route::resource('/menus', 'MenuController');
Route::get('/menus', 'MenuController@menu');
Route::get('/createMenu', 'MenuController@createMenu');
Route::post('/createMenu', 'MenuController@postcreateMenu');
Route::get('/menus/edit/{id}', 'MenuController@editMenu');
Route::post('/updateMenu', 'MenuController@postUpdateMenu');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

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
    return view('welcome');
});

Route::group(['prefix' => 'user/'], function () {

	Route::get('/getMessage', [
        'as' => 'user.doMessage',
        'uses' => 'UserController@getMessage'
    ]);
    
    Route::get('/getOtp', [
        'as' => 'user.doMessage',
        'uses' => 'UserController@getMessage'
    ]);

	Route::post('/getMessage', [
        'as' => 'user.getMessage',
        'uses' => 'UserController@getMessage'
    ]);

	Route::get('/showMessage', [
        'as' => 'user.showMessage',
        'uses' => 'UserController@showMessage'
    ]);

	Route::post('/create', [
        'as' => 'user.create',
        'uses' => 'UserController@create'
    ]);       
	Route::post('/login', [
        'as' => 'user.login',
        'uses' => 'UserController@login'
    ]);       
});
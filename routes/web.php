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
        'uses' => 'UserController@sendOtp'
    ]);
    
    Route::get('/get-reset-otp', [
        'as' => 'user.getResetOtp',
        'uses' => 'UserController@resetOtp'
    ]);
    
    Route::post('/reset-password', [
        'as' => 'user.resetPassword',
        'uses' => 'UserController@resetPassword'
    ]);
    

    Route::get('/showMessage', [
        'as' => 'user.showMessage',
        'uses' => 'UserController@showMessage'
    ]);

    Route::post('/create', [
        'as' => 'user.create',
        'uses' => 'UserController@create'
    ]);

    Route::post('/verify-user', [
        'as' => 'user.verifyUser',
        'uses' => 'UserController@userVerifcation'
    ]);

    Route::post('/login', [
        'as' => 'user.login',
        'uses' => 'UserController@login'
    ]);

    Route::get('/logout', [
        'as' => 'user.logout',
        'uses' => 'UserController@logout'
    ]);

    Route::get('/get-captcha', [
        'as' => 'user.getCaptcha',
        'uses' => 'UserController@getCaptcha'
    ]);
});

Route::group(['prefix' => 'profile/', 'middleware' => 'checkSession'], function () {
    Route::get('/me', [
        'as' => 'profile.me',
        'uses' => 'ProfileController@me'
    ]);

    Route::group(['prefix' => 'modify/'], function () {
        Route::get('/personal', [
        'as' => 'profile.me',
        'uses' => 'ProfileController@me'
        ]);
    });
});

<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['middleware' => 'beta.redirect_not_activated'], function() {
    Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);
});

Route::group(['middleware' => 'beta.redirect_activated'], function() {
    Route::get('/login', ['as' => 'login', 'uses' => 'SteamController@login']);
    Route::get('/auth', ['as' => 'auth', 'uses' => 'SteamController@auth']);

    Route::get('/beta', ['as' => 'beta_home', 'uses' => 'BetaController@index']);
    Route::post('/subscribe', ['as' => 'subscribe', 'uses' => 'BetaSubscribeController@index']);

});

Route::get('/site', ['as' => 'site_home', 'uses' => 'MatchController@matches']);
Route::get('/logout', ['as' => 'logout', 'uses' => 'SteamController@logout']);
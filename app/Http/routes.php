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

Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);

Route::get('/login/{action?}', 'SteamController@login');
Route::get('/logout', 'SteamController@logout');

Route::get('/beta', ['as' => 'beta_home', 'uses' => 'BetaController@index']);
Route::post('/signup', ['as' => 'signup', 'uses' => 'SignupController@index']);

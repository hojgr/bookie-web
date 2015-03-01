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
	Route::get('/article/{id}', ['as' => 'article', 'uses' => 'ArticleController@show']);
	Route::get('/live', ['as' => 'live', 'uses' => 'HomeController@live']);
});

Route::group(['middleware' => 'beta.redirect_activated'], function() {
	Route::get('/beta', ['as' => 'beta_home', 'uses' => 'BetaController@index']);
	Route::post('/subscribe', ['as' => 'subscribe', 'uses' => 'BetaSubscribeController@index']);
});

// TODO: add admin middleware & roles
Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => 'admin.protect'], function() {
	Route::get('/', ['as' => 'admin_home', 'uses' => 'HomeController@index']);

	Route::resource('article', 'ArticleController');
	Route::resource('organization', 'OrganizationController');
	Route::resource('team', 'TeamController');
});

Route::get('/login', ['as' => 'login', 'uses' => 'SteamController@login']);
Route::get('/auth', ['as' => 'auth', 'uses' => 'SteamController@auth']);
Route::get('/logout', ['as' => 'logout', 'uses' => 'SteamController@logout']);

/**
 * Statically serve images from storage
 */
Route::get('upload_assets/{thing}/{type}/{filename}', ['as' => 'uploaded_asset', 'uses' => function($thing, $type, $filename) {
	if(!in_array($thing, ['logo', 'banner'])) {
		App::abort(403);
	}

	$path = storage_path($thing . "s/" . $type . "s") . "/$filename";

	$response = Response::make(File::get($path));
	$response->header('Content-Type', File::type($path));
	$response->header('Content-Size', File::size($path));

	return $response;
}]);
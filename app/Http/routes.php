<?php
/**
 * Application Routes
 *
 * Here is where you can register all of the routes for an application.
 * It's a breeze. Simply tell Laravel the URIs it should respond to
 * and give it the controller to call when that URI is requested.
 *
 * PHP version 5.6
 *
 * @category Class
 * @package  Base
 * @author   Michal Hojgr <michal.hojgr@gmail.com>
 * @license  MS Reference
 * @link     http://bookie.gg
 */
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

Route::get('/mailpreview', ['uses' => 'EmailController@firstclosedbeta']);
Route::get('/help', ['as' => 'help', 'uses' => 'HelpController@show']);

Route::group(
    ['middleware' => 'beta.active_only'],
    function () {
        Route::get(
            '/',
            ['as' => 'home', 'uses' => 'HomeController@index']
        );
        Route::get(
            '/profile/{id}',
            ['as' => 'profile', 'uses' => 'ProfileController@show']
        );
        Route::get(
            '/article/{id}',
            ['as' => 'article', 'uses' => 'ArticleController@show']
        );
        Route::get(
            '/match/{id}',
            ['as' => 'match', 'uses' => 'MatchController@show']
        );
        Route::get(
            '/bank',
            ['as' => 'bank', 'uses' => 'BankController@show']
        );
        Route::get(
            '/rules',
            ['as' => 'rules', 'uses' => 'SubpageController@rules']
        );
        Route::get(
            '/tos',
            ['as' => 'tos', 'uses' => 'SubpageController@tos']
        );
        Route::get(
            '/contact',
            ['as' => 'contact', 'uses' => 'SubpageController@contact']
        );
        Route::get(
            '/partners',
            ['as' => 'partners', 'uses' => 'SubpageController@partners']
        );

        // TODO: add admin roles
        Route::group(
            [
                'namespace' => 'Admin',
                'prefix' => 'admin',
                'middleware' => 'admin.protect'
            ],
            function () {
                Route::get(
                    '/',
                    ['as' => 'admin_home', 'uses' => 'HomeController@index']
                );

                Route::resource('article', 'ArticleController');
                Route::resource('organization', 'OrganizationController');
                Route::resource('team', 'TeamController');
                Route::resource('match', 'MatchController');

                Route::get(
                    'match/pickwinner/{matchid}/{tid}',
                    [
                        'as' => 'admin.match.pickwinner',
                        'uses' => 'MatchController@pickwinner'
                    ]
                );
                Route::resource('subpage', 'SubpageController');
            }
        );
    }
);


Route::group(
    ['middleware' => 'beta.not_active_only'],
    function () {
        Route::get(
            '/beta',
            ['as' => 'beta_home', 'uses' => 'BetaController@index']
        );
        Route::post(
            '/beta',
            ['as' => 'beta.activate', 'uses' => 'BetaController@activate']
        );
        Route::post(
            '/beta/subscribe',
            ['as' => 'beta.subscribe', 'uses' => 'BetaSubscribeController@index']
        );
    }
);

Route::get('/login', ['as' => 'login', 'uses' => 'SteamController@login']);
Route::get('/auth', ['as' => 'auth', 'uses' => 'SteamController@auth']);
Route::get('/logout', ['as' => 'logout', 'uses' => 'SteamController@logout']);

/**
 * Statically serve images from storage
 */
Route::get(
    'upload_assets/{thing}/{type}/{filename}',
    [
        'as' => 'uploaded_asset',
        'uses' => function ($thing, $type, $filename) {
            if (!in_array($thing, ['logo', 'banner'])) {
                App::abort(403);
            }

            $path = storage_path($thing . "s/" . $type . "s") . "/$filename";

            $response = Response::make(File::get($path));
            $response->header('Content-Type', File::type($path));
            $response->header('Content-Size', File::size($path));

            return $response;
        }
    ]
);

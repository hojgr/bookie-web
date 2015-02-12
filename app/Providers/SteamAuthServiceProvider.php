<?php namespace BookieGG\Providers;

use Hybrid_Auth;
use Illuminate\Support\ServiceProvider;

class SteamAuthServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		//
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->singleton('Hybrid_Auth', function($app) {
			return new Hybrid_Auth(array(
				"base_url"   => "http://localhost:8000/login/auth",
				"providers" => array (
					"OpenID" => array (
						"enabled" => true
					),
					"Steam"  => array (
						"enabled" => true,
						"wrapper" => array(
							'class'=>'Hybrid_Providers_Steam',
							'path' => $_SERVER['DOCUMENT_ROOT'].'/../vendor/hybridauth/hybridauth/additional-providers/hybridauth-steam/Providers/Steam.php'
						)
					)
				)
			));
		});
	}

}
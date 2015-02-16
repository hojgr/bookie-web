<?php namespace BookieGG\Providers;

use BookieGG\Services\SteamUtility;
use Illuminate\Support\ServiceProvider;

class SteamUtilityServiceProvider extends ServiceProvider {

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
		$this->app->singleton('BookieGG\Contracts\SteamUtilityInterface', function() {
            return new SteamUtility();
        });
	}

}

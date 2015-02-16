<?php namespace BookieGG\Providers;

use BookieGG\Repositories\Eloquent\BetaSubscriptionRepository;
use BookieGG\Repositories\Eloquent\UserRepository;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use BookieGG\Services\SteamUtility;

class AppServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		//
	}

	/**
	 * Register any application services.
	 *
	 * This service provider is a great spot to register your various container
	 * bindings with the application. As you can see, we are registering our
	 * "Registrar" implementation here. You can add your own bindings too!
	 *
	 * @return void
	 */
	public function register()
	{
        $this->app->singleton('BookieGG\Contracts\Repositories\UserRepositoryInterface', function(Application $app) {
            return $app->make(UserRepository::class);
        });

        $this->app->singleton('BookieGG\Contracts\Repositories\BetaSubscriptionRepositoryInterface',
            function(Application $app) {
                return $app->make(BetaSubscriptionRepository::class);
            }
        );

        $this->app->singleton('BookieGG\Contracts\SteamUtilityInterface', function(Application $app) {
            return $app->make(SteamUtility::class);
        });
	}

}

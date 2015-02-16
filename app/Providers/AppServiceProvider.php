<?php namespace BookieGG\Providers;

use BookieGG\Contracts\Repositories\UserRepositoryInterface;
use BookieGG\Repositories\Eloquent\BetaSubscriptionRepository;
use BookieGG\Repositories\Eloquent\UserRepository;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

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
        $this->app->singleton('BookieGG\Contracts\Repositories\UserRepositoryInterface', function() {
            return new UserRepository();
        });

        $this->app->singleton('BookieGG\Contracts\Repositories\BetaSubscriptionRepositoryInterface',
            function(Application $app) {
                return new BetaSubscriptionRepository($app->make('BookieGG\Contracts\Repositories\UserRepositoryInterface'));
            }
        );
	}

}

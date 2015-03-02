<?php namespace BookieGG\Providers;

use BookieGG\Repositories\Eloquent\ArticleRepository;
use BookieGG\Repositories\Eloquent\BetaSubscriptionRepository;
use BookieGG\Repositories\Eloquent\OrganizationRepository;
use BookieGG\Repositories\Eloquent\MatchRepository;
use BookieGG\Repositories\Eloquent\TeamRepository;
use BookieGG\Repositories\Eloquent\UserRepository;
use BookieGG\Services\ImageManager;
use BookieGG\Services\LogoUtility;
use BookieGG\Services\TimeUtility;
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
		$binds = [
			'BookieGG\Contracts\Repositories\UserRepositoryInterface' => UserRepository::class,
			'BookieGG\Contracts\Repositories\BetaSubscriptionRepositoryInterface'
				=> BetaSubscriptionRepository::class,
			'BookieGG\Contracts\SteamUtilityInterface' => SteamUtility::class,
			'BookieGG\Contracts\LogoUtilityInterface' => LogoUtility::class,
			'BookieGG\Contracts\Repositories\OrganizationRepositoryInterface' => OrganizationRepository::class,
			'BookieGG\Contracts\Repositories\TeamRepositoryInterface' => TeamRepository::class,
			'BookieGG\Contracts\Repositories\MatchRepositoryInterface' => MatchRepository::class,
			'BookieGG\Contracts\Repositories\ArticleRepositoryInterface' => ArticleRepository::class,
			'BookieGG\Contracts\ImageManagerInterface' => ImageManager::class,
			'BookieGG\Contracts\TimeUtilityInterface' => TimeUtility::class,
		];

		foreach($binds as $interface => $implementation) {
			$this->app->bind($interface, $implementation);
		}


	}

}

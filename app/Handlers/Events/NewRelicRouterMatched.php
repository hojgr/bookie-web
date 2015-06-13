<?php namespace BookieGG\Handlers\Events;


use Illuminate\Http\Request;
use Illuminate\Routing\Route;

class NewRelicRouterMatched {

	/**
	 * Create the event handler.
	 *
	 */
	public function __construct()
	{
		//
	}

	/**
	 * Handle the event.
	 *
	 * @param Route $route
	 * @param Request $request
	 * @internal param $router .matched  $event
	 */
	public function handle(Route $route, Request $request)
	{
		/*
		$name = $route->getActionName();

		$name = preg_replace('/BookieGG\\\\Http\\\\Controllers\\\\/', '', $name);

		newrelic_name_transaction($name);
		*/
	}

}

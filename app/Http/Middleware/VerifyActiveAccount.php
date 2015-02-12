<?php namespace BookieGG\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;

class VerifyActiveAccount {

	protected $excluded = ['beta_home', 'login', 'logout'];

	/**
	 * Keep non-active users on /beta landpage
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle(Request $request, Closure $next)
	{
		if(!$this->isExcludedRoute($request->route()->getName())) {
			if(!\Auth::user() || !\Auth::user()->active) {
				return \Redirect::route('beta_home');
			}
		}
		return $next($request);
	}

	/**
	 * Check whether given route is excluded from verification
	 *
	 * @param $name
	 * @return bool
	 */
	public function isExcludedRoute($name) {
		return in_array($name, $this->excluded);
	}
}

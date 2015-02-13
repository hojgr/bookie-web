<?php namespace BookieGG\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerifyActiveAccount {

	/**
	 * Keep non-active users on /beta landpage
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle(Request $request, Closure $next)
	{
        if(!\Auth::user() || !\Auth::user()->active) {
            return \Redirect::route('beta_home');
        }

		return $next($request);
	}
}

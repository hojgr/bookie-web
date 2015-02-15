<?php namespace BookieGG\Http\Middleware;

use Closure;

class RedirectActivatedAccounts {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
        if(\Auth::user() and \Auth::user()->active) {
            return \Redirect::route('home');
        }

		return $next($request);
	}

}

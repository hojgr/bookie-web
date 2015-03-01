<?php namespace BookieGG\Http\Middleware;

use Closure;

class ProtectAdmin {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		$user = \Auth::user();
		if(!\Auth::check())
			\App::abort(403);

		if($user->admin == 0)
			\App::abort(403);

		return $next($request);
	}

}

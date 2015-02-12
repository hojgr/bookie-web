<?php namespace BookieGG\Http\Middleware;

use BookieGG\Http\Controllers\SignupController;
use Closure;

class SignupInputValidator {

	/**
	 * Validates closed beta signup inputs.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		$input = \Input::all();
		$validator = \Validator::make($input, SignupController::$validation_rules);

		if($validator->fails())
			return \Redirect::route(SignupController::$validation_failure_route)
				->withErrors($validator)
				->withInput($input);

		return $next($request);
	}

}

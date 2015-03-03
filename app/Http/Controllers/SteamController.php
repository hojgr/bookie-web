<?php namespace BookieGG\Http\Controllers;

use BookieGG\Commands\CreateUser;
use BookieGG\Commands\RefreshUser;
use BookieGG\Http\Requests;

use BookieGG\Models\User;
use BookieGG\Services\SteamAuthenticator;
use Hybrid_Auth;

class SteamController extends Controller {
	/**
	 * Authenticates locally (tries to look for
	 * session locally, if it is not found
	 * redirect to SteamController@auth
	 * to authenticate with steam and return here
	 *
	 * Lifecycle
	 * @login => @auth => steam => @auth => @login
	 *
	 * @param SteamAuthenticator $auth
	 * @param User $user
	 * @return \Illuminate\Http\RedirectResponse
	 * @throws \Exception
	 */
	public function login(SteamAuthenticator $auth, User $user) {
		$auth->authenticate();
		$steam_user = $auth->getUser();

		if(empty($steam_user['display_name'])) {
			\Session::flash('message',
				[['type' => 'error', 'message' => "Authentication failed. Try again later or contact Bookie.GG staff"]]);

			return \Redirect::route('home');
		}

		$user = $user->where('steam_id', '=', $steam_user['steam_id'])->first();

		if(!$user)
			$user = $this->dispatch(new CreateUser($steam_user));
		else
			$user = $this->dispatch(new RefreshUser($user, $steam_user));

		\Auth::login($user, true);

		return \Redirect::route('home');
	}

	/**
	 * Authenticates with Steam OpenID service
	 *
	 * @param SteamAuthenticator $auth
	 */
	public function auth(SteamAuthenticator $auth) {
		$auth->process();
	}

	public function logout(Hybrid_Auth $ha) {
		$ha->logoutAllProviders();
		\Auth::logout();
		return \Redirect::route('home');
	}

}

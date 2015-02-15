<?php namespace BookieGG\Http\Controllers;

use BookieGG\Http\Requests;

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
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function login(SteamAuthenticator $auth) {
		$auth->authenticate();
		\Auth::loginUsingId($auth->getUser()->id);

		return \Redirect::route('beta_home');
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
		return \Redirect::route('beta_home');
	}

}

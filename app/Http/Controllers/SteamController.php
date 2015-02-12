<?php namespace BookieGG\Http\Controllers;

use BookieGG\Http\Requests;
use BookieGG\Http\Controllers\Controller;

use BookieGG\Services\SteamAuthenticator;
use Hybrid_Auth;
use Hybrid_Endpoint;
use Illuminate\Http\Request;

class SteamController extends Controller {
	/**
	 * @param SteamAuthenticator $auth
	 * @param string $action
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function login(SteamAuthenticator $auth, $action = '') {
		if ( $action == "auth" ) {
			$auth->process();
		}

		$auth->authenticate();
		$res = \Auth::loginUsingId($auth->getUser()->id);

		return \Redirect::to('/');
	}

	public function logout(Hybrid_Auth $ha) {
		$ha->logoutAllProviders();
	}

}

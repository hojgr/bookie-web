<?php


namespace BookieGG\Http\Controllers;


use BookieGG\Commands\SubscribeUserToBeta;
use Illuminate\Http\Request;

class SignupController extends Controller {

    public static $validation_failure_route = 'beta_home';

    public static $validation_rules = [
        'email' => 'required|email',
        'name' => 'required'
    ];

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index(Request $request) {
        $this->dispatch(new SubscribeUserToBeta(\Auth::user(), $request->input()));
        return \Redirect::route('beta_home');
    }
}
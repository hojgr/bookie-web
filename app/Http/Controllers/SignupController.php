<?php


namespace BookieGG\Http\Controllers;


use BookieGG\Models\SignUp;
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
        if(!\Auth::user()->signUp) {
            $signUp = new SignUp($request->input());
            \Auth::user()->signUp()->save($signUp);
        }

        return \Redirect::route('beta_home');
    }
}
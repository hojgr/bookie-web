<?php


namespace BookieGG\Http\Controllers;


use BookieGG\Models\SignUp;

class SignupController extends Controller {
    public function index() {
        $input = \Input::all();
        $validator = \Validator::make($input,  [
            'email' => 'required|email',
            'name' => 'required'
        ]);

        if($validator->fails())
            return \Redirect::route('beta_home')->withErrors($validator)->withInput($input);

        if(!\Auth::user()->signUp) {
            $signUp = new SignUp();
            $signUp->email = $input['email'];
            $signUp->name = $input['name'];

            \Auth::user()->signUp()->save($signUp);
        }

        return \Redirect::route('beta_home');
    }
}
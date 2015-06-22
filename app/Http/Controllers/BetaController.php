<?php

namespace BookieGG\Http\Controllers;


class BetaController extends Controller {
    public function index() {
        return view('beta/landing')
            ->with('queue_size', 248);
    }

    public function activate() {

        return \Redirect::route('beta_home')->with('error', 'Invalid code!');
    }
}

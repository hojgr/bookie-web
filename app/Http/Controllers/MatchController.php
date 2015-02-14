<?php

namespace BookieGG\Http\Controllers;


class MatchController extends Controller {
    public function matches() {
        return view('site/index');
    }
}
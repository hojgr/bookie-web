<?php

namespace BookieGG\Http\Controllers;


class BetaController extends Controller {
	public function index() {
		return view('beta/landing')
			->with('queue_size', 248)
			->with('user', (object) ['queue_spot' => 158, 'email' => 'johanringmann@gmail.com'] );
	}
}

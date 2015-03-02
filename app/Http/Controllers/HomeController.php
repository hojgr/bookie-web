<?php


namespace BookieGG\Http\Controllers;


use BookieGG\Contracts\Repositories\MatchRepositoryInterface;

class HomeController extends Controller {
	public function index(MatchRepositoryInterface $mri) {

		$form = function($time) {

		};

		return view("home/index")
			->with('matches', $mri->allDesc())
			->with('format_date', $form);
	}

	public function live() {
		return view("home/live");
	}
}
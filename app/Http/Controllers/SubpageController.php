<?php


namespace BookieGG\Http\Controllers;


use BookieGG\Contracts\SubpageServiceInterface;

class SubpageController extends Controller {
	public function rules(SubpageServiceInterface $ssi) {
		return view('subpage/index')
			->with('data', $ssi->getPage('Rules'));
	}

	public function tos(SubpageServiceInterface $ssi) {
		return view('subpage/index')
			->with('data', $ssi->getPage('Terms of Service'));
	}
}
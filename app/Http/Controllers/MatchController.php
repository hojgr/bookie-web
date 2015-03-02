<?php


namespace BookieGG\Http\Controllers;


use BookieGG\Contracts\Repositories\MatchRepositoryInterface;

class MatchController extends Controller {
	public function show(MatchRepositoryInterface $mri, $id) {
		return view("match/show")
			->with('match', $mri->find($id));
	}
}
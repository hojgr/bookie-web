<?php


namespace BookieGG\Repositories\Eloquent;


use BookieGG\Contracts\Repositories\MatchRepositoryInterface;
use BookieGG\Models\Match;

class MatchRepository implements MatchRepositoryInterface {

	public function save(Match $match)
	{
		$match->save();
		return $match;
	}

	public function all() {
		return Match::all();
	}

	public function delete(Match $match)
	{
		return $match->delete();
	}

	public function find($id)
	{
		return Match::find($id);
	}
}
<?php


namespace BookieGG\Repositories\Eloquent;


use BookieGG\Contracts\Repositories\MatchRepositoryInterface;
use BookieGG\Models\Match;
use BookieGG\Models\Organization;
use BookieGG\Models\Team;

class MatchRepository implements MatchRepositoryInterface {

	public function __construct() {

	}

	public function save(Organization $org, Match $match)
	{
		$org->matches()->save($match);
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

	public function addMatches(Match $match, Team $team1, Team $team2)
	{
		$match->teams()->saveMany([$team1, $team2]);
	}

	public function create(Organization $org, Team $t1, Team $t2, $bo, \DateTime $start)
	{
		$match = new Match();

		$match->bo = (int)$bo;
		$match->start = $start;

		$this->save($org, $match);
		$this->addMatches($match, $t1, $t2);
	}

	public function allDesc()
	{
		return Match::orderBy('id', 'DESC')->get();
	}
}
<?php


namespace BookieGG\Repositories\Eloquent;


use BookieGG\Contracts\Repositories\MatchRepositoryInterface;
use BookieGG\Models\Match;
use BookieGG\Models\MatchNote;
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

	public function create(Organization $org, Team $t1, Team $t2, $bo, \DateTime $start, $note)
	{
		$match = new Match();

		$match->bo = (int)$bo;
		$match->start = $start;

		$this->save($org, $match);
		$this->addMatches($match, $t1, $t2);

		if(strlen($note) > 0) {
			$match_note = new MatchNote();
			$match_note->note = $note;

			$match->note()->save($match_note);
		}
	}

	public function change(Match $match, $bo, $start, $note, Team $t1, Team $t2) {
		$match->bo = (int)$bo;
		if(!empty($start)) {
			$match->start = new \DateTime($start);
		}

		if(strlen($note) == 0) {
			if($match->note) {
				$match->note->delete();
			}
		} else {
			if ($match->note) {
				$match->note->note = $note;
				$match->note->save();
			} else {
				$match_note = new MatchNote();
				$match_note->note = $note;

				$match->note()->save($match_note);
			}
		}

		if($t1 !== $match->teams[0]) {
			\DB::update(\DB::raw('UPDATE match_team SET team_id=? WHERE match_id=? and team_id=?'), [$t1->id, $match->id, $match->teams[0]->id]);
		}
		if($t2 !== $match->teams[1]) {
			\DB::update(\DB::raw('UPDATE match_team SET team_id=? WHERE match_id=? and team_id=?'), [$t2->id, $match->id, $match->teams[1]->id]);
		}

		$match->save();
	}

	public function allDesc()
	{
		return Match::orderBy('status', 'ASC')->orderBy('start', 'ASC')->get();
	}
}
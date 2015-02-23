<?php


namespace BookieGG\Contracts\Repositories;


use BookieGG\Models\Match;
use BookieGG\Models\MatchHost;
use BookieGG\Models\Team;

/**
 * Interface MatchRepositoryInterface
 * @package BookieGG\Contracts\Repositories
 */
interface MatchRepositoryInterface {
	public function save(MatchHost $host, Match $match);
	public function all();
	public function delete(Match $match);
	public function find($id);
	public function addMatches(Match $match, Team $team1, Team $team2);
	public function create(MatchHost $host, Team $t1, Team $t2, $bo, \DateTime $time);
}
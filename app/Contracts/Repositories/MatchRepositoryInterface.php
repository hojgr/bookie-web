<?php


namespace BookieGG\Contracts\Repositories;


use BookieGG\Models\Match;

interface MatchRepositoryInterface {
	public function save(Match $match);
	public function all();
	public function delete(Match $match);
	public function find($id);
}
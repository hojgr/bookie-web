<?php


namespace BookieGG\Repositories\Eloquent;


use BookieGG\Contracts\Repositories\TeamRepositoryInterface;
use BookieGG\Models\Team;

class TeamRepository implements TeamRepositoryInterface {

	public function create($name)
	{
		$team = new Team();

		$team->name = $name;

		$team->save();

		return $team;
	}

	public function getAll()
	{
		return Team::all();
	}

	public function getById($id)
	{
		return Team::find($id);
	}

	public function delete(Team $team) {
		return $team->delete();
	}
}
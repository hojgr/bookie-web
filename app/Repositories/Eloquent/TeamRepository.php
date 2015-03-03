<?php


namespace BookieGG\Repositories\Eloquent;


use BookieGG\Contracts\Repositories\TeamRepositoryInterface;
use BookieGG\Models\ImageType;
use BookieGG\Models\Team;
use BookieGG\Models\TeamImage;

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



	public function save(Team $t, TeamImage $ti, ImageType $it)
	{
		$t->save();

		$ti->image_type_id = $it->id;

		$t->images()->save($ti);
	}
}
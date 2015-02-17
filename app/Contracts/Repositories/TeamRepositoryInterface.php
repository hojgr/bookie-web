<?php


namespace BookieGG\Contracts\Repositories;


use BookieGG\Models\Team;

interface TeamRepositoryInterface {
	public function create($name);
	public function getAll();
	public function getById($id);
	public function delete(Team $team);
}
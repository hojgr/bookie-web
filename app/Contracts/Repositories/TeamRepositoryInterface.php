<?php


namespace BookieGG\Contracts\Repositories;


use BookieGG\Models\ImageType;
use BookieGG\Models\Team;
use BookieGG\Models\TeamImage;

interface TeamRepositoryInterface {
    public function create($name);
    public function getAll();
    public function getById($id);
    public function delete(Team $team);

    public function save(Team $t, TeamImage $ti, ImageType $it);
}
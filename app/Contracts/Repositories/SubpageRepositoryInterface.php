<?php


namespace BookieGG\Contracts\Repositories;


use BookieGG\Subpage;

interface SubpageRepositoryInterface {
    public function create($name, $content);
    public function get($name);
    public function getAll();
    public function find($id);
    public function save(Subpage $s);
}
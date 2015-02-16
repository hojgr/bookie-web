<?php


namespace BookieGG\Contracts\Repositories;

use BookieGG\Models\MatchHost;

interface MatchHostRepositoryInterface {
	/**
	 * Creates a new MatchHost
	 *
	 * @param $name
	 * @param $url
	 * @return MatchHost
	 */
	public function create($name, $url);

	public function getAll();

	public function delete(MatchHost $matchHost);

	public function findById($id);
}
<?php


namespace BookieGG\Repositories\Eloquent;


use BookieGG\Contracts\Repositories\MatchHostRepositoryInterface;
use BookieGG\Models\MatchHost;

class MatchHostRepository implements MatchHostRepositoryInterface {

	/**
	 * Creates a new MatchHost
	 *
	 * @param $name
	 * @param $url
	 * @return MatchHost
	 */
	public function create($name, $url)
	{
		$host = new MatchHost(['name' => $name, 'url' => $url]);
		$host->save();
		return $host;
	}
}
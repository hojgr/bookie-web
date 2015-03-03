<?php


namespace tests\Repositories\Eloquent;


use BookieGG\Repositories\Eloquent\TeamRepository;
use BookieGG\Models\Team;

class TeamRepositoryTest extends \TestCase {
	public function testCreate() {
		$repo = new TeamRepository();
		$return = $repo->create("test");

		$this->assertSame("test", $return->name);
		$this->assertInstanceOf(Team::class, $return);
	}
}

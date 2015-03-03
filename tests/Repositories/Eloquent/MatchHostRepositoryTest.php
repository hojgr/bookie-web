<?php


namespace tests\Repositories\Eloquent;


use BookieGG\Models\MatchHost;
use BookieGG\Repositories\Eloquent\MatchHostRepository;

class MatchHostRepositoryTest extends \TestCase {
	public function testCreate() {
		$repo = new MatchHostRepository();

		$model = $repo->create("a", "http://a.cz");

		$this->assertSame("a", $model->name);
		$this->assertSame("http://a.cz", $model->url);
		$this->assertInstanceOf(MatchHost::class, $model);
	}
}

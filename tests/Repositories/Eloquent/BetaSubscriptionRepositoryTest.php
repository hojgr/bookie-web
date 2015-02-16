<?php


namespace tests\Repositories\Eloquent;


use BookieGG\Models\BetaSubscription;
use BookieGG\Models\User;
use BookieGG\Repositories\Eloquent\BetaSubscriptionRepository;
use BookieGG\Repositories\Eloquent\UserRepository;

class BetaSubscriptionRepositoryTest extends \TestCase {
	public function testCreate() {
		$user = new User();
		$name = "x";
		$email = "y";

		$userMock = \Mockery::mock(UserRepository::class);
		$userMock->shouldReceive('subscribe')->once();

		$repo = new BetaSubscriptionRepository($userMock);
		$return = $repo->create($user, $name, $email);

		$this->assertEquals($name, $return->name);
		$this->assertEquals($email, $return->email);
		$this->assertInstanceOf(BetaSubscription::class, $return);

		$userMock->mockery_verify();
	}

	public function testIsSubscribed() {
		$userRepoMock = \Mockery::mock(UserRepository::class);
		$userMock = \Mockery::mock(User::class);
		$userMock->shouldReceive('getAttribute')->with('subscription')->andReturn(true);

		$repo = new BetaSubscriptionRepository($userRepoMock);
		$this->assertTrue($repo->isSubscribed($userMock));
	}
}

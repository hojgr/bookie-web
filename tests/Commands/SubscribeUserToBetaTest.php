<?php


namespace tests\Commands;


use BookieGG\Commands\SubscribeUserToBeta;
use BookieGG\Models\User;

class SubscribeUserToBetaTest extends \TestCase {
    public function testSubscribe_call_save() {
        $user = new User();

        $interface = \Mockery::mock('BookieGG\Contracts\Repositories\BetaSubscriptionRepositoryInterface');

        $interface->shouldReceive('isSubscribed')->once()->with($user)->andReturn(false);
        $interface->shouldReceive('create')->once()->withArgs([$user, "a", "b"]);

        $command = new SubscribeUserToBeta($user, "a", "b");

        $command->handle($interface);

        $interface->mockery_verify();
    }

    public function testSubscribe_call_dont_save() {
        $this->setExpectedException('BookieGG\Exceptions\UserAlreadySubscribed');
        $user = new User();

        $interface = \Mockery::mock('BookieGG\Contracts\Repositories\BetaSubscriptionRepositoryInterface');

        $interface->shouldReceive('isSubscribed')->once()->with($user)->andReturn(true);
        $interface->shouldReceive('create')->never();

        $command = new SubscribeUserToBeta($user, "a", "b");

        $command->handle($interface);

        $interface->mockery_verify();
    }
}

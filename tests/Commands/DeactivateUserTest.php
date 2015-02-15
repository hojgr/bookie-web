<?php


namespace tests\Commands;

use BookieGG\Commands\DeactivateUser;
use BookieGG\Models\User;

class DeactivateUserTest extends \TestCase {
    public function testDeactivateUser_successful() {
        $user = new User();

        $mock = \Mockery::mock('BookieGG\Contracts\Repositories\UserRepositoryInterface');
        $mock->shouldReceive('deactivate')->with($user)->andReturn(true);

        $command = new DeactivateUser($user);

        $command->handle($mock);

        $mock->mockery_verify();
    }

    public function testDeactivateUser_already_Deactivated() {
        $this->setExpectedException('BookieGG\Exceptions\UserNotActivated');
        $user = new User();

        $mock = \Mockery::mock('BookieGG\Contracts\Repositories\UserRepositoryInterface');
        $mock->shouldReceive('deactivate')->with($user)->andReturn(false);

        $command = new DeactivateUser($user);

        $command->handle($mock);

        $mock->mockery_verify();
    }
}
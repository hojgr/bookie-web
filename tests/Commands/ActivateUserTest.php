<?php


namespace tests\Commands;

use BookieGG\Commands\ActivateUser;
use BookieGG\Models\User;

class ActivateUserTest extends \TestCase {
    public function testActivateUser_successful() {
        $user = new User();

        $mock = \Mockery::mock('BookieGG\Contracts\Repositories\UserRepositoryInterface');
        $mock->shouldReceive('activate')->with($user)->andReturn(true);

        $command = new ActivateUser($user);

        $command->handle($mock);

        $mock->mockery_verify();
    }

    public function testActivateUser_already_activated() {
        $this->setExpectedException('BookieGG\Exceptions\UserAlreadyActivated');
        $user = new User();

        $mock = \Mockery::mock('BookieGG\Contracts\Repositories\UserRepositoryInterface');
        $mock->shouldReceive('activate')->with($user)->andReturn(false);

        $command = new ActivateUser($user);

        $command->handle($mock);

        $mock->mockery_verify();
    }
}
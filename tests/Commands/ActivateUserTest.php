<?php


namespace tests\Commands;

use BookieGG\Commands\ActivateUser;
use BookieGG\Models\User;

class ActivateUserTest extends \TestCase {
    public function testActivateUser_successful() {
        $mock = \Mockery::mock('BookieGG\Models\User');

        $mock->shouldReceive("activate")->times(1)->andReturn(true);
        $mock->shouldReceive("save")->times(1);

        $command = new ActivateUser($mock);

        $command->handle();

        $mock->mockery_verify();
    }

    public function testActivateUser_already_activated() {
        $this->setExpectedException('BookieGG\Exceptions\UserAlreadyActivated');
        $mock = \Mockery::mock('BookieGG\Models\User');

        $mock->shouldReceive("activate")->once()->andReturn(false);
        $mock->shouldReceive("getAttribute")->once()->with("id")->andReturn(1);

        $command = new ActivateUser($mock);

        $command->handle();
    }
}
<?php


namespace tests\Commands;

use BookieGG\Commands\DeactivateUser;
use BookieGG\Models\User;

class DeactivateUserTest extends \TestCase {
    public function testDeactivateUser_successful() {
        $mock = \Mockery::mock('BookieGG\Models\User');

        $mock->shouldReceive("deactivate")->times(1)->andReturn(true);
        $mock->shouldReceive("save")->times(1);

        $command = new DeactivateUser($mock);

        $command->handle();

        $mock->mockery_verify();
    }

    public function testDeactivateUser_already_deactivated() {
        $this->setExpectedException('BookieGG\Exceptions\UserNotActivated');
        $mock = \Mockery::mock('BookieGG\Models\User');

        $mock->shouldReceive("deactivate")->once()->andReturn(false);
        $mock->shouldReceive("getAttribute")->once()->with("id")->andReturn(1);

        $command = new DeactivateUser($mock);

        $command->handle();
    }
}
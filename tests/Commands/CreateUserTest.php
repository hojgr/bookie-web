<?php


namespace tests\Commands;


use BookieGG\Commands\CreateUser;
use BookieGG\Models\User;

class CreateUserTest extends \TestCase {
    public function testCreateUser() {
        $args = ['steamId' => 'a', 'displayName' => 'b', 'profileName' => 'c', 'avatarPath' => 'd'];
        $userRepositoryMock = \Mockery::mock('BookieGG\Contracts\Repositories\UserRepositoryInterface');
        $userRepositoryMock->shouldReceive('createUser')->once()->withArgs(array_values($args));

        $createUser = new CreateUser($args);
        $createUser->handle($userRepositoryMock);

        $userRepositoryMock->mockery_verify();
    }
}

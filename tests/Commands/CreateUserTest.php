<?php


namespace tests\Commands;


use BookieGG\Commands\CreateUser;
use BookieGG\Models\User;

class CreateUserTest extends \TestCase {
    public function testCreateUser() {
        $args = ['steam_id' => 'a', 'display_name' => 'b', 'profile_name' => 'c', 'avatar_path' => 'd'];
        $userRepositoryMock = \Mockery::mock('BookieGG\Contracts\Repositories\UserRepositoryInterface');
        $userRepositoryMock->shouldReceive('createUser')->once()->withArgs(array_values($args));

        $createUser = new CreateUser($args);
        $createUser->handle($userRepositoryMock);

        $userRepositoryMock->mockery_verify();
    }
}

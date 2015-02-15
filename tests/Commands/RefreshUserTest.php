<?php


namespace tests\Commands;


use BookieGG\Commands\RefreshUser;
use BookieGG\Models\User;

class RefreshUserTest extends \TestCase {
    public function testRefreshUser() {
        $raw_data = (array)$this->createRawData();
        $refresh_user = new RefreshUser($this->createUserObject(), $raw_data);

        $repoMock = \Mockery::mock('BookieGG\Contracts\Repositories\UserRepositoryInterface');
        $repoMock->shouldReceive('save')->once()->andReturnUsing(function ($user) { return $user; });

        $user = $refresh_user->handle($repoMock);

        $this->assertEquals("76561178907171", $user->steamId);
        $this->assertEquals("testusr", $user->profileName);
        $this->assertEquals("e7/e766c6dc582e9456aa2a0b00298054c9de_medium.jpg", $user->avatarPath);
        $this->assertEquals("testuser", $user->displayName);

        $repoMock->mockery_verify();
    }

    public function testRefreshUserNoSave() {
        $user = new User();
        $user->profileName = "a";
        $user->avatarPath = "b";
        $user->displayName = "c";

        $data = ['profileName' => "a", 'avatarPath' => "b", 'displayName' => "c"];

        $refresh_user = new RefreshUser($user, $data);

        $repoMock = \Mockery::mock('BookieGG\Contracts\Repositories\UserRepositoryInterface');
        $repoMock->shouldReceive('save')->never();

        $refresh_user->handle($repoMock);

        $repoMock->mockery_verify();
    }

    public function createRawData() {
        $user = new \stdClass();
        $user->identifier = "http://steamcommunity.com/openid/id/76561178907171";
        $user->steamId = "76561178907171";
        $user->profileName = "testusr";
        $user->avatarPath = "e7/e766c6dc582e9456aa2a0b00298054c9de_medium.jpg";
        $user->displayName = "testuser";

        return $user;
    }

    public function createUserObject() {
        $user = new User();
        $user->profileName = "old_profile";
        $user->avatarPath = "old_path.jpg";
        $user->displayName = "old disp name";
        $user->steamId = "76561178907171";

        return $user;
    }
}

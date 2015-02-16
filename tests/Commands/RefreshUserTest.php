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

        $this->assertEquals("76561178907171", $user->steam_id);
        $this->assertEquals("testusr", $user->profile_name);
        $this->assertEquals("e7/e766c6dc582e9456aa2a0b00298054c9de_medium.jpg", $user->avatar_path);
        $this->assertEquals("testuser", $user->display_name);

        $repoMock->mockery_verify();
    }

    public function testRefreshUserNoSave() {
        $user = new User();
        $user->profile_name = "a";
        $user->avatar_path = "b";
        $user->display_name = "c";

        $data = ['profile_name' => "a", 'avatar_path' => "b", 'display_name' => "c"];

        $refresh_user = new RefreshUser($user, $data);

        $repoMock = \Mockery::mock('BookieGG\Contracts\Repositories\UserRepositoryInterface');
        $repoMock->shouldReceive('save')->never();

        $refresh_user->handle($repoMock);

        $repoMock->mockery_verify();
    }

    public function createRawData() {
        $user = new \stdClass();
        $user->identifier = "http://steamcommunity.com/openid/id/76561178907171";
        $user->steam_id = "76561178907171";
        $user->profile_name = "testusr";
        $user->avatar_path = "e7/e766c6dc582e9456aa2a0b00298054c9de_medium.jpg";
        $user->display_name = "testuser";

        return $user;
    }

    public function createUserObject() {
        $user = new User();
        $user->profile_name = "old_profile";
        $user->avatar_path = "old_path.jpg";
        $user->display_name = "old disp name";
        $user->steam_id = "76561178907171";

        return $user;
    }
}

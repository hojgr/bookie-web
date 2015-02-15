<?php


namespace tests\Commands;


use BookieGG\Commands\CreateUser;
use BookieGG\Models\User;

class CreateUserTest extends \TestCase {
    public function testCreateUser() {
        $args = (array)$this->createTestUser();

        $create_user = new CreateUser($args);

        $user = $create_user->handle(new User());

        $this->assertEquals("76561178907171", $user->steam_id);
        $this->assertEquals("testusr", $user->profile_name);
        $this->assertEquals("e7/e766c6dc582e9456aa2a0b00298054c9de_medium.jpg", $user->avatar_path);
        $this->assertEquals("testuser", $user->display_name);
    }

    public function createTestUser() {
        $user = new \stdClass();
        $user->identifier = "http://steamcommunity.com/openid/id/76561178907171";
        $user->steam_id = "76561178907171";
        $user->profile_url = "http://steamcommunity.com/id/testusr";
        $user->avatar_url = "http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/e7/e766c6dc582e9456aa2a0b00298054c9de_medium.jpg";
        $user->display_name = "testuser";

        return $user;
    }
}

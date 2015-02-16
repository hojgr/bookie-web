<?php


namespace tests\Services;


use BookieGG\Services\SteamAuthenticator;

class SteamAuthenticatorTest extends \TestCase {
    // not testing process and authenticate - untestable because of stupid static calls
    // who the fuck uses static calls for everything anyways...
    // might write own authenticator on top of Hybrid_Auth sometime

    public function testGetUser() {
        $auth = \Mockery::mock('Hybrid_Auth');
        $endpoint = \Mockery::mock('Hybrid_Endpoint');

        $adapter = \Mockery::mock('Hybrid_Provider_Adapter');
        $adapter->shouldReceive('getUserProfile')->andReturn($this->createTestUser());

        $auth->shouldReceive('authenticate')->with("Steam")->andReturn($adapter);

        $steamUtil = \Mockery::mock('BookieGG\Contracts\SteamUtilityInterface');

        $steamUtil->shouldReceive('profileURLToProfileName')->once()->andReturn('testusr');
        $steamUtil->shouldReceive('avatarURLToAvatarPath')->once()->andReturn('e7/e766c6dc582e9456aa2a0b00298054c9de_medium.jpg');

        $steam_auth = new SteamAuthenticator($auth, $endpoint, $steamUtil);

        $steam_auth->authenticate();
        $user = $steam_auth->getUser();

        $this->assertEquals("76561178907171", $user['steam_id']);
        $this->assertEquals("http://steamcommunity.com/openid/id/76561178907171", $user['identifier']);
        $this->assertEquals("testusr", $user['profile_name']);
        $this->assertEquals("e7/e766c6dc582e9456aa2a0b00298054c9de_medium.jpg", $user['avatar_path']);
        $this->assertEquals("testuser", $user['display_name']);

        $auth->mockery_verify();
        $endpoint->mockery_verify();
        $adapter->mockery_verify();
    }

    public function createTestUser() {
        $user = new \stdClass();
        $user->identifier = "http://steamcommunity.com/openid/id/76561178907171";
        $user->steam_id = "76561178907171";
        $user->profile_url = "http://steamcommunity.com/id/testusr";
        $user->photo_url = "http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/e7/e766c6dc582e9456aa2a0b00298054c9de_medium.jpg";
        $user->display_name = "testuser";

        return $user;
    }
}

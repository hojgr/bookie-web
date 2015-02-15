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

        $steam_auth = new SteamAuthenticator($auth, $endpoint);

        $steam_auth->authenticate();
        $user = $steam_auth->getUser();

        $comparision_user = $this->createTestUser();

        $this->assertEquals($comparision_user->steam_id, $user['steam_id']);
        $this->assertEquals($comparision_user->identifier, $user['identifier']);
        $this->assertEquals($comparision_user->profileURL, $user['profile_url']);
        $this->assertEquals($comparision_user->photoURL, $user['avatar_url']);
        $this->assertEquals($comparision_user->displayName, $user['display_name']);

        $auth->mockery_verify();
        $endpoint->mockery_verify();
        $adapter->mockery_verify();
    }

    public function createTestUser() {
        $user = new \stdClass();
        $user->identifier = "http://steamcommunity.com/openid/id/76561178907171";
        $user->steam_id = "76561178907171";
        $user->profileURL = "http://steamcommunity.com/id/testusr";
        $user->photoURL = "http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/e7/e766c6dc582e9456aa2a0b00298054c9de_medium.jpg";
        $user->displayName = "testuser";

        return $user;
    }
}

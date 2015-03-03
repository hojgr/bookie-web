<?php


namespace tests\Services;

use BookieGG\Services\SteamUtility;

/**
 * Example data
 * Profile url: http://steamcommunity.com/id/testusr
 * Avatar url: http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/e7/e766c6dc582e94560298054c9de_medium.jpg
 *
 * Class SteamUtilityTest
 * @package tests\Services
 */
class SteamUtilityTest extends \PHPUnit_Framework_TestCase {
    private $avatarCDNPrefix = "http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/";
    private $profilePrefix = "http://steamcommunity.com/id/";
    private $exampleProfileName = "testusr";
    private $exampleAvatarPath = "e7/e766c6dc582e94560298054c9de_medium.jpg";

    public function testAvatarURLToAvatarPath() {
        $steamUtility = new SteamUtility();
        $avatarPath = $steamUtility->avatarURLToAvatarPath($this->avatarCDNPrefix . $this->exampleAvatarPath);

        $this->assertSame($this->exampleAvatarPath, $avatarPath);
    }

    public function testProfileURLToProfileName_success() {
        $steamUtility = new SteamUtility();
        $profileName = $steamUtility->profileURLToProfileName($this->profilePrefix . $this->exampleProfileName);

        $this->assertSame($this->exampleProfileName, $profileName);
    }

    public function testProfileURLToProfileName_throws_exception() {
        $this->setExpectedException('BookieGG\Exceptions\InvalidSteamProfileURL');
        $steamUtility = new SteamUtility();
        $steamUtility->profileURLToProfileName("wrong");
    }

    public function testAvatarPathToAvatarURL() {
        $steamUtility = new SteamUtility();

        $expectedURL = $this->avatarCDNPrefix . "test";
        $givenURL = $steamUtility->avatarPathToAvatarURL("test");

        $this->assertSame($expectedURL, $givenURL);
    }

    public function testProfileNameToProfileURL() {
        $steamUtlity = new SteamUtility();

        $expectedURL = $this->profilePrefix . "johnDoe/";
        $givenURL = $steamUtlity->profileNameToProfileURL("johnDoe");

        $this->assertSame($expectedURL, $givenURL);
    }
}

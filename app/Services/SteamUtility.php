<?php


namespace BookieGG\Services;


use BookieGG\Contracts\SteamUtilityInterface;
use BookieGG\Exceptions\InvalidSteamProfileURL;

class SteamUtility implements SteamUtilityInterface {
    const STEAM_AVATAR_CDN_AKAMAI = "http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/";
    const STEAM_PROFILE = "http://steamcommunity.com/id/";

    /**
     * Parses avatarURL and returns path to avatar
     *
     * @param $avatarURL
     * @return mixed
     */
    public function avatarURLToAvatarPath($avatarURL)
    {
        return preg_replace('~^(.*)/avatars/~', '', $avatarURL);
    }

    /**
     * Parses profileURL and returns profile name
     *
     * @param $profileURL
     * @return mixed
     * @throws \Exception
     */
    public function profileURLToProfileName($profileURL)
    {
        if(!preg_match("-/id/([^\\^/]+)-", $profileURL, $matches))
            throw new InvalidSteamProfileURL("Unable to parse profileURL (profile url: {$profileURL}");
        return $matches[1];
    }


    /**
     * Prepends steam CDN URL to avatar path
     *
     * @param $avatarPath
     * @return string
     */
    public function avatarPathToAvatarURL($avatarPath)
    {
        return self::STEAM_AVATAR_CDN_AKAMAI . $avatarPath;
    }

    /**
     * Prepends steam URL to make url to given profile name
     *
     * @param $profileName
     * @return mixed
     */
    public function profileNameToProfileURL($profileName)
    {
        return self::STEAM_PROFILE . $profileName . "/";
    }
}
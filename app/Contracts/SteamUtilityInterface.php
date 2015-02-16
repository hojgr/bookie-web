<?php


namespace BookieGG\Contracts;


interface SteamUtilityInterface {

	/**
	 * Parses avatarURL and returns path to avatar
	 *
	 * @param $avatarURL
	 * @return string
	 */
	public function avatarURLToAvatarPath($avatarURL);

	/**
	 * Parses profileURL and returns profile name
	 *
	 * @param $profileURL
	 * @return string
	 */
	public function profileURLToProfileName($profileURL);

	/**
	 * Prepends steam CDN URL to avatar path
	 *
	 * @param $avatarPath
	 * @return string
	 */
	public function avatarPathToAvatarURL($avatarPath);

	/**
	 * Prepends steam URL to make url to given profile name
	 *
	 * @param $profileName
	 * @return mixed
	 */
	public function profileNameToProfileURL($profileName);
}
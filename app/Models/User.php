<?php


namespace BookieGG\Models;
use Eloquent;
use Illuminate\Contracts\Auth\Authenticatable;

/**
 * Class SteamUser
 *
 * Class to hold data after steam authentication
 *
 * @package BookieGG\Models
 */
class User extends Eloquent implements Authenticatable {

    public function signUp() {
        return $this->hasOne('BookieGG\Models\SignUp');
    }

    public function setProfileUrl($profile_url) {
        if(!preg_match("-/id/([^\\^/]+)-", $profile_url, $matches))
            throw new \Exception("Unable to parse profileURL (profile url: {$profile_url}");
        $this->profile_name = $matches[1];
    }

    public function setAvatarUrl($avatar_url) {
        $this->avatar_path = preg_replace('~^(.*)/avatars/~', '', $avatar_url);
    }

    public function getProfileUrl() {
        return "http://steamcommunity.com/id/" . $this->profile_name . "/";
    }

    public function getAvatarUrl() {
        return "http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/" . $this->avatar_path;
    }

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->id;
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->steam_id;
    }

    /**
     * Get the token value for the "remember me" session.
     *
     * @return string
     */
    public function getRememberToken()
    {
        return null;
    }

    /**
     * Set the token value for the "remember me" session.
     *
     * @param  string $value
     * @return void
     */
    public function setRememberToken($value)
    {

    }

    /**
     * Get the column name for the "remember me" token.
     *
     * @return string
     */
    public function getRememberTokenName()
    {
        return null;
    }
}
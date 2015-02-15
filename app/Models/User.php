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

    protected $fillable = ['steam_id', 'display_name'];

    public function subscription() {
        return $this->hasOne('BookieGG\Models\BetaSubscription');
    }


    /**
     * Activate user account
     *
     * Returns true if user was activated
     * false if he was not
     *
     * @return bool
     */
    public function activate() {
        if(!$this->active) {
            $this->active = true;
            return true;
        } else return false;
    }

    /**
     * Deactivates user account
     *
     * Returns true if user was activated
     * false if he was not
     *
     * @return bool
     */
    public function deactivate() {
        if($this->active) {
            $this->active = false;
            return true;
        } else return false;
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

    public function getDisplayName() {
        return $this->display_name;
    }

    public function setDisplayName($name) {
        $this->display_name = $name;
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
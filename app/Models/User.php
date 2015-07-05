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

    protected $fillable = ['steam_id', 'display_name', 'avatar_path', 'profile_name'];

    public function subscription() {
        return $this->hasOne('BookieGG\Models\BetaSubscription');
    }

    public function user_trade_link() {
        return $this->hasOne('BookieGG\Models\UserTradeLink');
    }

    public function articles() {
        return $this->hasMany('BookieGG\Models\Article');
    }

    public function bank() {
        return $this->hasMany('BookieGG\Models\UserBank');
    }

    public function user_last_trade() {
        return $this->hasOne('BookieGG\Models\UserTrade')->latest("id");
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
        return $this->remember_token;
    }

    /**
     * Set the token value for the "remember me" session.
     *
     * @param  string $value
     * @return void
     */
    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    /**
     * Get the column name for the "remember me" token.
     *
     * @return string
     */
    public function getRememberTokenName()
    {
        return 'remember_token';
    }
}

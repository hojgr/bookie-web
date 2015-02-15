<?php


namespace BookieGG\Services;


use BookieGG\Contracts\Authenticatable;
use BookieGG\Models\User;
use Hybrid_Endpoint;

class SteamAuthenticator implements Authenticatable {

    /**
     * @var \Hybrid_Auth
     */
    protected $hybrid_auth;

    /**
     * @var \Hybrid_Provider_Model_OpenID
     */
    protected $auth_provider;

    /**
     * @param \Hybrid_Auth $ha
     */
    public function __construct(\Hybrid_Auth $ha) {
        $this->hybrid_auth = $ha;
    }

    /**
     * Either redirects or returns auth provider
     *
     * If user is not authenticated with Steam it redirects
     * him to steam website to log in. Otherwise it stores steam auth provider for further use
     *
     * @return void
     */
    public function authenticate()
    {
        $this->auth_provider = $this->hybrid_auth->authenticate("Steam");
    }

    /**
     * Process a request coming back from steam login
     *
     * @return void
     */
    public function process()
    {
        try {
            Hybrid_Endpoint::process();
        } catch (\Exception $e) {
            \Log::error("Error at Hybrid_Endpoint process (SteamController@login): $e");
        }
    }

    /**
     *
     *
     * @return bool
     */
    public function isAuthenticated()
    {
        if(!$this->auth_provider instanceof \Hybrid_Provider_Model)
            return false;

        return $this->auth_provider->isUserConnected();
    }

    /**
     * @throws \Exception
     * @return \BookieGG\Models\User
     *
     */
    public function getUser()
    {
        /**
         * Has properties
         * identifier, profileURL, photoURL, displayName
         *
         * @var \Hybrid_User_Profile
         */
        $user_profile = $this->auth_provider->getUserProfile();

        if(!preg_match("([0-9]+)", $user_profile->identifier, $matches) || !isset($matches[0])) {
            \Log::error("Received STEAM ID did not contain an ID! {$user_profile->identifier}");
            throw new \Exception("Received STEAM ID did not contain an ID! {$user_profile->identifier}");
        }

        $steam_id = $matches[0];

        /**
         * @var \BookieGG\Models\User $user
         */
        $user = User::where('steam_id', '=', $steam_id)->first();

        if($user === null) {
            // register user
            $user = new User;
            $user->steam_id = $steam_id;
            $user->display_name = $user_profile->displayName;
            $user->setProfileUrl($user_profile->profileURL);
            $user->setAvatarUrl($user_profile->photoURL);

            $user->save();
        } else {
            $force_save = false;
            if($user->getProfileUrl() !== $user_profile->profileURL) {
                $user->setProfileUrl($user_profile->profileURL);
                $force_save = true;
            }

            if($user->getAvatarUrl() !== $user_profile->photoURL) {
                $user->setAvatarUrl($user_profile->photoURL);
                $force_save = true;
            }

            if($user->display_name !== $user_profile->displayName) {
                $user->display_name = $user_profile->displayName;
                $force_save = true;
            }

            if($force_save)
                $user->save();
        }

        return $user;
    }

    public function logout() {
        $this->hybrid_auth->logoutAllProviders();
    }

}
<?php


namespace BookieGG\Repositories\Eloquent;


use BookieGG\Contracts\Repositories\UserRepositoryInterface;
use BookieGG\Models\BetaSubscription;
use BookieGG\Models\User;

class UserRepository implements UserRepositoryInterface {

    /**
     * @param User $user
     * @return User
     */
    public function activate(User $user)
    {
        $user->activate();
        $user->save();
        return $user;
    }

    /**
     * @param User $user
     * @return User
     */
    public function deactivate(User $user) {
        $user->deactivate();
        $user->save();
        return $user;
    }

    /**
     * @param User $user
     * @return User
     */
    public function save(User $user)
    {
        $user->save();
        return $user;
    }

    public function createUser($steamId, $displayName, $profileName, $avatarPath)
    {
        $user = new User([
            "steam_id" => $steamId,
            "display_name" => $displayName,
            "profile_name" => $profileName,
            "avatar_path" => $avatarPath
        ]);

        $user->save();
        return $user;
    }

    public function subscribe(User $user, BetaSubscription $betaSubscription)
    {
        $user->subscription()->save($betaSubscription);
    }
}
<?php


namespace BookieGG\Repositories\Eloquent;


use BookieGG\Contracts\Repositories\UserRepositoryInterface;
use BookieGG\Models\User;

class UserRepository implements UserRepositoryInterface {

    public function activate(User $user)
    {
        $return = $user->activate();
        $user->save();
        return $return;
    }

    public function save(User $user)
    {
        $user->save();
    }

    public function createUser($steamId, $displayName, $profileName, $avatarPath)
    {
        $user = new User([
            "steamId" => $steamId,
            "displayName" => $displayName,
            "profileName" => $profileName,
            "avatarPath" => $avatarPath
        ]);

        return $user->save();
    }
}
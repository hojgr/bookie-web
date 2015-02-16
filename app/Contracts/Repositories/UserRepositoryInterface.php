<?php


namespace BookieGG\Contracts\Repositories;


use BookieGG\Models\BetaSubscription;
use BookieGG\Models\User;

interface UserRepositoryInterface {
    public function activate(User $user);
    public function save(User $user);
    public function createUser($steamId, $displayName, $profileName, $avatarPath);

    public function deactivate(User $user);

    public function subscribe(User $user, BetaSubscription $betaSubscription);
}
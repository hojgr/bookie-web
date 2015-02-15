<?php


namespace BookieGG\Repositories\Eloquent;


use BookieGG\Contracts\Repositories\UserRepositoryInterface;
use BookieGG\Models\User;

class UserRepository implements UserRepositoryInterface {

    public function activate(User $user)
    {
        $user->activate();
        $user->save();
    }

    public function save(User $user)
    {
        $user->save();
    }
}
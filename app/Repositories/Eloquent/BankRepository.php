<?php

namespace BookieGG\Repositories\Eloquent;

use BookieGG\Models\User;

class BankRepository {
    public function getBank(User $user) {
        return $user->bank()->get();
    }
}
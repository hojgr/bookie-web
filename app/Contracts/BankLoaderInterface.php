<?php

namespace BookieGG\Contracts;

use BookieGG\Models\User;

interface BankLoaderInterface {
    function load(User $user); 
}

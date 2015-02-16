<?php


namespace BookieGG\Contracts\Repositories;


use BookieGG\Models\BetaSubscription;
use BookieGG\Models\User;

interface BetaSubscriptionRepositoryInterface {
    /**
     * @param BetaSubscription $betaSubscription
     * @return BetaSubscription
     */
    public function save(BetaSubscription $betaSubscription);

    /**
     * @param User $user
     * @param $name
     * @param $email
     * @return BetaSubscription
     */
    public function create(User $user, $name, $email);

    /**
     * @param User $user
     * @return mixed
     */
    public function isSubscribed(User $user);
}
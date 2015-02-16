<?php


namespace BookieGG\Contracts\Repositories;


use BookieGG\Models\BetaSubscription;
use BookieGG\Models\User;

interface BetaSubscriptionRepositoryInterface {

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
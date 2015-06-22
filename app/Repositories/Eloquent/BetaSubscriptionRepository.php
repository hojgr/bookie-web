<?php


namespace BookieGG\Repositories\Eloquent;


use BookieGG\Contracts\Repositories\BetaSubscriptionRepositoryInterface;
use BookieGG\Contracts\Repositories\UserRepositoryInterface;
use BookieGG\Models\BetaSubscription;
use BookieGG\Models\User;

class BetaSubscriptionRepository implements BetaSubscriptionRepositoryInterface {

    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepo) {

        $this->userRepository = $userRepo;
    }

    /**
     * @param User $user
     * @param string $name
     * @param string $email
     * @return BetaSubscription
     */
    public function create(User $user, $name, $email)
    {
        $subscription = new BetaSubscription(['name' => $name, 'email' => $email]);
        $this->userRepository->subscribe($user, $subscription);

        return $subscription;
    }

    /**
     * @param User $user
     * @return mixed
     */
    public function isSubscribed(User $user)
    {
        return $user->subscription;
    }
}
<?php namespace BookieGG\Commands;

use BookieGG\Contracts\Repositories\UserRepositoryInterface;
use BookieGG\Exceptions\UserNotActivated;
use BookieGG\Models\User;
use Illuminate\Contracts\Bus\SelfHandling;

class DeactivateUser extends Command implements SelfHandling {
    /**
     * @var User
     */
    private $user;

    /**
     * @param User $user
     */
    public function __construct(User $user) {

        $this->user = $user;
    }

    /**
     * @param UserRepositoryInterface $userRepository
     * @throws UserNotActivated
     */
    public function handle(UserRepositoryInterface $userRepository)
	{
        /**
         * By checking return value we can
         * prevent SQL query if user was already
         * activated prior to this attept
         */
		if(!$userRepository->deactivate($this->user)) {
            throw new UserNotActivated("User #" . $this->user->id . " is not activated");
        }
	}

}

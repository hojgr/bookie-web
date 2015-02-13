<?php namespace BookieGG\Commands;

use BookieGG\Exceptions\UserAlreadyActivated;
use BookieGG\Models\User;
use Illuminate\Contracts\Bus\SelfHandling;

class ActivateUser extends Command implements SelfHandling {
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
     * Execute the command.
     *
     * @throws UserAlreadyActivated
     */
	public function handle()
	{
        /**
         * By checking return value we can
         * prevent SQL query if user was already
         * activated prior to this attept
         */
		if($this->user->activate()) {
            $this->user->save();
        } else {
            throw new UserAlreadyActivated("User #" . $this->user->id . " is already activated");
        }
	}

}

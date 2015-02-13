<?php namespace BookieGG\Commands;

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
	 * @return void
	 */
	public function handle()
	{
        /**
         * By checking return value we can
         * prevent SQL query if user was already
         * activated prior to this attept
         */
		if($this->user->activate())
            $this->user->save();

	}

}

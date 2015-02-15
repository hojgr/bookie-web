<?php namespace BookieGG\Commands;

use BookieGG\Exceptions\UserAlreadySubscribed;

use BookieGG\Models\BetaSubscription;
use BookieGG\Models\User;
use Illuminate\Contracts\Bus\SelfHandling;

class SubscribeUserToBeta extends Command implements SelfHandling {
	/**
	 * @var User
	 */
	private $user;
	/**
	 * @var array
	 */
	private $input;

	/**
	 * Create a new command instance.
	 * @param User $user
	 * @param array $input
	 */
	public function __construct(User $user, array $input)
	{
		$this->user = $user;
		$this->input = $input;
	}

    /**
     * Execute the command.
     *
     * @throws UserAlreadySubscribed
     */
	public function handle()
	{
		if(!$this->user->subscription) {
			$subscription = new BetaSubscription($this->input);
			$this->user->subscription()->save($subscription);
		} else {
            throw new UserAlreadySubscribed("User #" . $this->user->id . " is already subscribed!");
        }
	}

}

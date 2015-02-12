<?php namespace BookieGG\Commands;

use BookieGG\Commands\Command;

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
		//
		$this->user = $user;
		$this->input = $input;
	}

	/**
	 * Execute the command.
	 *
	 * @return void
	 */
	public function handle()
	{
		if(!$this->user->signUp) {
			$signUp = new BetaSubscription($this->input);
			$this->user->signUp()->save($signUp);
		}
	}

}

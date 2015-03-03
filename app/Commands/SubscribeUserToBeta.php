<?php namespace BookieGG\Commands;

use BookieGG\Contracts\Repositories\BetaSubscriptionRepositoryInterface;
use BookieGG\Exceptions\UserAlreadySubscribed;

use BookieGG\Models\User;
use Illuminate\Contracts\Bus\SelfHandling;

class SubscribeUserToBeta extends Command implements SelfHandling {
	/**
	 * @var User
	 */
	private $user;

	/**
	 * @var string
	 */
	private $name;

	/**
	 * @var string
	 */
	private $email;

	/**
	 * Create a new command instance.
	 * @param User $user
	 * @param string $name
	 * @param string $email
	 */
	public function __construct(User $user, $name, $email)
	{
		$this->user = $user;
		$this->name = $name;
		$this->email = $email;
	}

	/**
	 * Execute the command.
	 *
	 * @param BetaSubscriptionRepositoryInterface $betaSusbcriptionRepo
	 * @throws UserAlreadySubscribed
	 */
	public function handle(BetaSubscriptionRepositoryInterface $betaSusbcriptionRepo)
	{
		if(!$betaSusbcriptionRepo->isSubscribed($this->user)) {
			$betaSusbcriptionRepo->create($this->user, $this->name, $this->email);
		} else {
			throw new UserAlreadySubscribed("User #" . $this->user->id . " is already subscribed!");
		}
	}

}

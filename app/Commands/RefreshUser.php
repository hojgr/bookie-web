<?php namespace BookieGG\Commands;

use BookieGG\Contracts\Repositories\UserRepositoryInterface;
use BookieGG\Models\User;
use Illuminate\Contracts\Bus\SelfHandling;

class RefreshUser extends Command implements SelfHandling {
	/**
	 * @var array
	 */
	private $parameters;
	/**
	 * @var User
	 */
	private $user;

	/**
	 * Create a new command instance.
	 *
	 * @param User $user
	 * @param array $parameters
	 */
	public function __construct(User $user, array $parameters)
	{
		$this->parameters = $parameters;
		$this->user = $user;
	}

	/**
	 * Execute the command.
	 *
	 * @param UserRepositoryInterface $userRepository
	 * @return User
	 */
	public function handle(UserRepositoryInterface $userRepository)
	{
		$save = false;

		$map = ['profile_name', 'avatar_path', 'display_name'];
		foreach($map as $name) {
			if ($this->user->$name !== $this->parameters[$name]) {
				$this->user->$name = $this->parameters[$name];
				$save = true;
			}
		}


		if($save) {
			return $userRepository->save($this->user);
		}

		return $this->user;
	}

}

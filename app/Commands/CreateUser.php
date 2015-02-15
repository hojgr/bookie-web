<?php namespace BookieGG\Commands;

use BookieGG\Contracts\Repositories\UserRepositoryInterface;
use BookieGG\Models\User;
use Illuminate\Contracts\Bus\SelfHandling;

class CreateUser extends Command implements SelfHandling {
    /**
     * @var array
     */
    private $parameters;

    /**
     * Create a new command instance.
     * @param array $parameters
     */
	public function __construct(array $parameters)
	{
        $this->parameters = $parameters;
    }

    /**
     * Creates command
     *
     * @param UserRepositoryInterface $userRepository
     * @return User
     */
	public function handle(UserRepositoryInterface $userRepository)
	{
        return $userRepository->createUser(
            $this->parameters['steamId'],
            $this->parameters['displayName'],
            $this->parameters['profileName'],
            $this->parameters['avatarPath']
        );
	}

}

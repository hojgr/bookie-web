<?php namespace BookieGG\Commands;

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
     * @param User $user
     * @return User
     */
	public function handle(User $user)
	{
        $user->fill($this->parameters);

        $user->setAvatarUrl($this->parameters['avatar_url']);
        $user->setProfileUrl($this->parameters['profile_url']);

        $user->save();

        return $user;
	}

}

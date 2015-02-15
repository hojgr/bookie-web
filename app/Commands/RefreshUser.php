<?php namespace BookieGG\Commands;

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
     * @return User
	 */
	public function handle()
	{
        $save = false;

        $map = [
            'ProfileUrl' => 'profile_url',
            'AvatarUrl' => 'avatar_url',
            'DisplayName' => 'display_name',
        ];

        foreach($map as $method_name => $array_key) {
            if ($this->user->{'get' . $method_name}() !== $this->parameters[$array_key]) {
                $this->user->{'set' . $method_name}($this->parameters[$array_key]);
                $save = true;
            }
        }

        if($save)
            $this->user->save();

        return $this->user;
	}

}

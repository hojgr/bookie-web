<?php
namespace BookieGG\Console\Commands\User;

use BookieGG\Commands\ActivateUser;
use BookieGG\Models\User;

class UserActivate extends UserChangeActivation {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'user:activate';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Activates user';

	/**
	 * Create a new command instance.
	 *
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$this->process_change(function(User $user) {
			return new ActivateUser($user);
		}, "was activated");
	}

}

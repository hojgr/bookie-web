<?php namespace BookieGG\Console\Commands;

use BookieGG\Commands\DeactivateUser;
use BookieGG\Models\User;

class UserDeactivate extends UserChangeActivation {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'user:deactivate';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Deactivates user';

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
			return new DeactivateUser($user);
		}, "was deactivated");
	}


}

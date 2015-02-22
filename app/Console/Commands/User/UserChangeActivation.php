<?php namespace BookieGG\Console\Commands\User;

use BookieGG\Exceptions\UserAlreadyActivated;
use BookieGG\Exceptions\UserNotActivated;
use BookieGG\Models\User;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Class is abstract because is not usable without
 * being extended. Only provides utilities for both
 * user activation and deactivation.
 */
abstract class UserChangeActivation extends Command {

	/**
	 * Create a new command instance.
	 *
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Both, activate and deactivate commands
	 * share almost all logic. This logic
	 * is abstracted except command creation
	 * and success message.
	 *
	 * @param callable $create_command Returns instance of Command
	 * @param $success_message string
	 * @return void
	 */
	public function process_change(\Closure $create_command, $success_message)
	{
		$id = $this->argument('id');
		$user = User::whereId($id)->first();

		if(!$user) {
			$this->error($this->formatMessage($id, "was not found"));
		} else {
			try {
				\Bus::dispatch($create_command($user));
				$this->info($this->formatMessage($id, $success_message));
			} catch (UserAlreadyActivated $e) {
				$this->error($e->getMessage());
			} catch (UserNotActivated $e) {
				$this->error($e->getMessage());
			}
		}
	}

	public function formatMessage($id, $appendix) {
		return "User #" . $id . " " . $appendix;
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [
			['id', InputArgument::REQUIRED, 'User ID'],
		];
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return [];
	}

}

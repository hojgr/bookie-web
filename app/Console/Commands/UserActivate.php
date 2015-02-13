<?php namespace BookieGG\Console\Commands;

use BookieGG\Commands\ActivateUser;
use BookieGG\Exceptions\UserAlreadyActivated;
use BookieGG\Models\User;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

class UserActivate extends Command {

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
        $id = $this->argument('id');
		$user = User::whereId($id)->first();

        if(!$user) {
            $this->error($this->formatMessage($id, "was not found"));
        } else {
            try {
                \Bus::dispatch(new ActivateUser($user));
                $this->info($this->formatMessage($id, "was activated"));
            } catch (UserAlreadyActivated $e) {
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

<?php namespace BookieGG\Console\Commands;

use BookieGG\Exceptions\UserNotActivated;
use BookieGG\Commands\DeactivateUser;
use BookieGG\Models\User;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

class UserDeactivate extends Command {

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
        $id = $this->argument('id');
        $user = User::whereId($id)->first();

        if(!$user) {
            $this->error($this->formatMessage($id, "was not found"));
        } else {
            try {
                \Bus::dispatch(new DeactivateUser($user));
                $this->info($this->formatMessage($id, "was deactivated"));
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

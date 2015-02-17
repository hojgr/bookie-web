<?php namespace BookieGG\Console\Commands;

use BookieGG\Contracts\Repositories\TeamRepositoryInterface;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

class TeamCreate extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'team:create';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Creates a team';
	/**
	 * @var TeamRepositoryInterface
	 */
	private $teamRepositoryInterface;

	/**
	 * Create a new command instance.
	 * @param TeamRepositoryInterface $teamRepositoryInterface
	 */
	public function __construct(TeamRepositoryInterface $teamRepositoryInterface)
	{
		parent::__construct();
		$this->teamRepositoryInterface = $teamRepositoryInterface;
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$name = $this->argument('name');

		$this->teamRepositoryInterface->create($name);

		$this->info("Team '$name' has been successfully created");
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [
			['name', InputArgument::REQUIRED, 'Team name'],
		];
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return [
		];
	}

}

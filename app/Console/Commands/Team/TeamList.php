<?php namespace BookieGG\Console\Commands\Team;

use BookieGG\Contracts\Repositories\TeamRepositoryInterface;
use Illuminate\Console\Command;

class TeamList extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'team:list';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Lists all teams';
	/**
	 * @var TeamRepositoryInterface
	 */
	private $teamRepositoryInterface;

	/**
	 * Create a new command instance.
	 *
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
		$teams = $this->teamRepositoryInterface->getAll();

		$this->table(['#', 'name'], array_map(function($team) {
			return [$team['id'], $team['name']];
		}, $teams->toArray()));
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [
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

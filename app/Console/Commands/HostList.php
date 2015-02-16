<?php namespace BookieGG\Console\Commands;

use BookieGG\Repositories\Eloquent\MatchHostRepository;
use Illuminate\Console\Command;

class HostList extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'host:list';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Command description.';
	/**
	 * @var MatchHostRepository
	 */
	private $matchHostRepository;

	/**
	 * Create a new command instance.
	 *
	 * @param MatchHostRepository $matchHostRepository
	 */
	public function __construct(MatchHostRepository $matchHostRepository)
	{
		parent::__construct();
		$this->matchHostRepository = $matchHostRepository;
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$hosts = $this->matchHostRepository->getAll();

		$this->table(['#', 'Name', "URL"], array_map(function($host) {
			return [$host['id'], $host['name'], $host['url']];
		}, $hosts->toArray()));
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

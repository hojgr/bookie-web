<?php namespace BookieGG\Console\Commands;

use BookieGG\Repositories\Eloquent\MatchHostRepository;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

class HostDelete extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'host:delete';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Lists all hosts';
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
		$host = $this->matchHostRepository->findById($this->argument('id'));

		if(!$host) {
			$this->error("Host #" . $this->argument('id') . " does not exist!");
		} else {
			$delete = $this->matchHostRepository->delete($host);

			if ($delete === true) {
				$this->info("Host '" . $host->name . "' was successfully deleted.");
			} else {
				$this->error("Host #" . $this->argument('id') . " was not deleted!");
			}
		}
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [
			['id', InputArgument::REQUIRED, 'ID of host to be deleted'],
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

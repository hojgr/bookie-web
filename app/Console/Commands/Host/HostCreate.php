<?php namespace BookieGG\Console\Commands\Host;

use BookieGG\Repositories\Eloquent\MatchHostRepository;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

class HostCreate extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'host:create';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Creates new match host';
	/**
	 * @var MatchHostRepository
	 */
	private $matchHostRepository;

	/**
	 * Create a new command instance.
	 * @param MatchHostRepository $mhr
	 */
	public function __construct(MatchHostRepository $mhr)
	{
		parent::__construct();
		$this->matchHostRepository = $mhr;
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$this->matchHostRepository->create($this->argument('name'), $this->argument('url'));
		$this->info("Match host '" . $this->argument('name') . "' was successfully created.'");
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [
			['name', InputArgument::REQUIRED, 'Host name (eg. ESEA)'],
			['url', InputArgument::OPTIONAL, 'Host URL (eg. http://play.esea.net/)']
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

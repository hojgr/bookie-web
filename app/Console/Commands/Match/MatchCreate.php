<?php namespace BookieGG\Console\Commands\Match;

use BookieGG\Contracts\Repositories\MatchRepositoryInterface;
use BookieGG\Models\Match;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

class MatchCreate extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'match:create';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Creates a match';
	/**
	 * @var MatchRepositoryInterface
	 */
	private $mri;

	/**
	 * Create a new command instance.
	 * @param MatchRepositoryInterface $mri
	 */
	public function __construct(MatchRepositoryInterface $mri)
	{
		parent::__construct();
		$this->mri = $mri;
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$bo = $this->argument('bo');
		$time = new \DateTime($this->argument('start'));

		$this->confirm("Create a match [BO$bo; start: " . $time->format('d.m.Y H:i') . "]");

		$match = new Match();

		$match->bo = (int)$bo;
		$match->start = $time;

		$this->mri->save($match);
		$this->info("Match created");
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [
			['bo', InputArgument::REQUIRED, 'Best of #'],
			['start', InputArgument::REQUIRED, 'Start (ie: 22.2.2015 23:30)']
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

<?php namespace BookieGG\Console\Commands\Match;

use BookieGG\Contracts\Repositories\MatchRepositoryInterface;
use Illuminate\Console\Command;

class MatchList extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'match:list';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Command description.';
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
		$teams = $this->mri->all();

		$this->table(['#', 'Start', 'BO'], array_map(function($r) {
			return [$r['id'], $r['start'], $r['bo']];
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

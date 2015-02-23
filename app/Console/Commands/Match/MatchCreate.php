<?php namespace BookieGG\Console\Commands\Match;

use BookieGG\Contracts\Repositories\MatchRepositoryInterface;
use BookieGG\Contracts\Repositories\TeamRepositoryInterface;
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
	 * @var TeamRepositoryInterface
	 */
	private $tri;

	/**
	 * Create a new command instance.
	 * @param MatchRepositoryInterface $mri
	 * @param TeamRepositoryInterface $tri
	 */
	public function __construct(MatchRepositoryInterface $mri, TeamRepositoryInterface $tri)
	{
		parent::__construct();
		$this->mri = $mri;
		$this->tri = $tri;
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

		$teams = [];
		$args = ['team1', 'team2'];

		foreach($args as $t) {
			$id = $this->argument($t);
			$team = $this->tri->getById($id);
			if(!$team) {
				$this->error("Team #$id was not found");
				exit;
			}

			$teams[] = $team;
		}

		$match = new Match();

		$match->bo = (int)$bo;
		$match->start = $time;

		$match = $this->mri->save($match);

		$this->mri->addMatches($match, $teams[0], $teams[1]);

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
			['start', InputArgument::REQUIRED, 'Start (ie: 22.2.2015 23:30)'],
			['team1', InputArgument::REQUIRED, 'ID of Team 1'],
			['team2', InputArgument::REQUIRED, 'ID of Team 2']
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

<?php namespace BookieGG\Commands;

use BookieGG\Commands\Command;

use BookieGG\Contracts\Repositories\MatchRepositoryInterface;
use BookieGG\Contracts\Repositories\TeamRepositoryInterface;
use Illuminate\Contracts\Bus\SelfHandling;

class EditMatch extends Command implements SelfHandling {
	/**
	 * @var
	 */
	private $match_id;
	/**
	 * @var
	 */
	private $bo;
	/**
	 * @var \DateTime
	 */
	private $start;
	/**
	 * @var
	 */
	private $note;
	/**
	 * @var
	 */
	private $t1;
	/**
	 * @var
	 */
	private $t2;

	/**
	 * Create a new command instance.
	 * @param $match_id
	 * @param $bo
	 * @param \DateTime $start
	 * @param $note
	 * @param $t1
	 * @param $t2
	 */
	public function __construct($match_id, $bo, $start, $note, $t1, $t2)
	{
		$this->match_id = $match_id;
		$this->bo = $bo;
		$this->start = $start;
		$this->note = $note;
		$this->t1 = $t1;
		$this->t2 = $t2;
	}

	/**
	 * Execute the command.
	 *
	 * @param MatchRepositoryInterface $mri
	 */
	public function handle(MatchRepositoryInterface $mri, TeamRepositoryInterface $tri)
	{
		$mri->change($mri->find($this->match_id), $this->bo, $this->start, $this->note, $tri->getById($this->t1), $tri->getById($this->t2));
	}
}

<?php namespace BookieGG\Commands;

use BookieGG\Commands\Command;

use BookieGG\Contracts\Repositories\MatchRepositoryInterface;
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
	 * Create a new command instance.
	 * @param $match_id
	 * @param $bo
	 * @param \DateTime $start
	 * @param $note
	 */
	public function __construct($match_id, $bo, $start, $note)
	{
		$this->match_id = $match_id;
		$this->bo = $bo;
		$this->start = $start;
		$this->note = $note;
	}

	/**
	 * Execute the command.
	 *
	 * @param MatchRepositoryInterface $mri
	 */
	public function handle(MatchRepositoryInterface $mri)
	{
		$mri->change($mri->find($this->match_id), $this->bo, $this->start, $this->note);
	}
}

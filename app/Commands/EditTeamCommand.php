<?php namespace BookieGG\Commands;

use BookieGG\Commands\Command;

use BookieGG\Contracts\ImageManagerInterface;
use BookieGG\Contracts\Repositories\TeamRepositoryInterface;
use Illuminate\Contracts\Bus\SelfHandling;

class EditTeamCommand extends Command implements SelfHandling {
	/**
	 * @var
	 */
	private $id;
	/**
	 * @var
	 */
	private $name;
	/**
	 * @var
	 */
	private $logo;

	/**
	 * Create a new command instance.
	 *
	 * @param $id
	 * @param $name
	 * @param $logo
	 */
	public function __construct($id, $name, $logo)
	{
		$this->id = $id;
		$this->name = $name;
		$this->logo = $logo;
	}

	/**
	 * Execute the command.
	 *
	 * @param TeamRepositoryInterface $tri
	 * @param ImageManagerInterface $imi
	 */
	public function handle(TeamRepositoryInterface $tri, ImageManagerInterface $imi)
	{
		$team = $tri->getById($this->id);

		$team->name = $this->name;

		$team->save();

		if($this->logo) {
			if($team->getLogo() == null) {

			} else {
				$imi->storeLogo($this->logo, $team->getLogo()->filename);
			}
		}
	}

}

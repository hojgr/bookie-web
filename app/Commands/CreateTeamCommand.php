<?php namespace BookieGG\Commands;

use BookieGG\Commands\Command;

use BookieGG\Contracts\ImageManagerInterface;
use BookieGG\Contracts\Repositories\TeamRepositoryInterface;
use BookieGG\Models\ImageType;
use BookieGG\Models\Team;
use BookieGG\Models\TeamImage;
use Illuminate\Contracts\Bus\SelfHandling;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class CreateTeamCommand extends Command implements SelfHandling {
	/**
	 * @var
	 */
	private $team;
	/**
	 * @var UploadedFile
	 */
	private $logo;

	/**
	 * Create a new command instance.
	 * @param $team
	 * @param UploadedFile $logo
	 */
	public function __construct($team, UploadedFile $logo)
	{
		//
		$this->team = $team;
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
		$filename = $imi->storeLogo($this->logo);

		$organization = new Team();

		$organization->name = $this->team;

		$image_type = ImageType::where('type', '=', 'logo')->firstOrFail();

		$team_image = new TeamImage();
		$team_image->filename = $filename;

		$tri->save($organization, $team_image, $image_type);
	}

}

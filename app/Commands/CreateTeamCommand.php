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
	private $name;
	/**
	 * @var UploadedFile
	 */
	private $logo;
	/**
	 * @var
	 */
	private $shortname;

	/**
	 * Create a new command instance.
	 * @param $name
	 * @param $shortname
	 * @param UploadedFile $logo
	 */
	public function __construct($name, $shortname, UploadedFile $logo)
	{
		//
		$this->name = $name;
		$this->logo = $logo;
		$this->shortname = $shortname;
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

		$team = new Team();

		$team->name = $this->name;
		if($this->shortname == "")
			$team->short_name = $this->name;
		else
			$team->short_name = $this->shortname;

		$image_type = ImageType::where('type', '=', 'logo')->firstOrFail();

		$team_image = new TeamImage();
		$team_image->filename = $filename;

		$tri->save($team, $team_image, $image_type);
	}

}

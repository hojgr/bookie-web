<?php namespace BookieGG\Commands;

use BookieGG\Commands\Command;

use BookieGG\Contracts\ImageManagerInterface;
use BookieGG\Contracts\Repositories\OrganizationRepositoryInterface;
use Illuminate\Contracts\Bus\SelfHandling;
use Intervention\Image\Image;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class EditOrganizationCommand extends Command implements SelfHandling {
	/**
	 * @var
	 */
	private $name;
	/**
	 * @var
	 */
	private $url;
	/**
	 * @var
	 */
	private $id;
	/**
	 * @var
	 */
	private $file;

	/**
	 * Create a new command instance.
	 * @param $id
	 * @param $name
	 * @param $url
	 * @param $file
	 */
	public function __construct($id, $name, $url, $file)
	{
		$this->name = $name;
		$this->url = $url;
		$this->id = $id;
		$this->file = $file;
	}

	/**
	 * Execute the command.
	 *
	 * @param OrganizationRepositoryInterface $ori
	 */
	public function handle(OrganizationRepositoryInterface $ori, ImageManagerInterface $imi)
	{
		$org = $ori->findById($this->id);

		$org->name = $this->name;
		$org->url = $this->url;

		$org->save();

		if($this->file) {
			$imi->storeLogo($this->file, $org->getLogo()->filename);
		}
	}

}

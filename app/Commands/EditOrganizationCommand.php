<?php namespace BookieGG\Commands;

use BookieGG\Commands\Command;

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
	public function handle(OrganizationRepositoryInterface $ori)
	{
		$org = $ori->findById($this->id);

		$org->name = $this->name;
		$org->url = $this->url;

		$org->save();

		if($this->file) {
			$this->storeLogo($this->file, $org->getLogo()->filename);
		}
	}


	public function storeLogo(UploadedFile $logo, $filename) {

		$this->resizeImageOnDisk($logo);

		$logo->move(storage_path('logos/organizations'), $filename);

		return $filename;
	}

	public function resizeImageOnDisk(UploadedFile $logo) {
		$img = \Image::make($logo->getRealPath());

		$d = $this->getGreatestDimension($img);
		$img->resizeCanvas($d, $d);
		$img->resize(128, 128);

		$img->save();
	}

	public function getGreatestDimension(Image $i) {
		return ($i->getHeight() > $i->getWidth()) ? $i->getHeight() : $i->getWidth();
	}

}

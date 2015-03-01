<?php namespace BookieGG\Commands;

use BookieGG\Commands\Command;

use BookieGG\Contracts\Repositories\OrganizationRepositoryInterface;
use BookieGG\Models\ImageType;
use BookieGG\Models\Organization;
use BookieGG\Models\OrganizationImage;
use Illuminate\Contracts\Bus\SelfHandling;
use Intervention\Image\Image;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class CreateOrganizationCommand extends Command implements SelfHandling {
	/**
	 * @var
	 */
	private $name;
	/**
	 * @var
	 */
	private $url;
	/**
	 * @var UploadedFile
	 */
	private $logo;

	/**
	 * Create a new command instance.
	 *
	 * @param $name
	 * @param $url
	 * @param UploadedFile $logo
	 */
	public function __construct($name, $url, UploadedFile $logo)
	{
		//
		$this->name = $name;
		$this->url = $url;
		$this->logo = $logo;
	}

	/**
	 * Execute the command.
	 *
	 * @param OrganizationRepositoryInterface $ori
	 */
	public function handle(OrganizationRepositoryInterface $ori)
	{
		$filename = $this->storeLogo($this->logo);

		$organization = new Organization();

		$organization->name = $this->name;
		$organization->url = $this->url;

		$image_type = ImageType::where('type', '=', 'logo')->firstOrFail();

		$organization_image = new OrganizationImage();
		$organization_image->filename = $filename;

		$ori->save($organization, $organization_image, $image_type);
	}

	public function storeLogo(UploadedFile $logo) {
		$logo_storage = $this->generateLogoFilename(
			$logo->getClientOriginalName(), $logo->getClientOriginalExtension()
		);

		$this->resizeImageOnDisk($logo);

		$logo->move(storage_path('logos/organizations'), $logo_storage);

		return $logo_storage;
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

	public function generateLogoFilename($original_name, $filetype) {
		$name = preg_replace("/[^a-zA-Z0-9]+/", "", $original_name);

		return $name . "-" . md5(str_random(64)) . "." . $filetype;
	}

}

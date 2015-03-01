<?php namespace BookieGG\Commands;

use BookieGG\Commands\Command;

use BookieGG\Contracts\ImageManagerInterface;
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
	 * @param ImageManagerInterface $imi
	 */
	public function handle(OrganizationRepositoryInterface $ori, ImageManagerInterface $imi)
	{
		$filename = $imi->storeLogo($this->logo);

		$organization = new Organization();

		$organization->name = $this->name;
		$organization->url = $this->url;

		$image_type = ImageType::where('type', '=', 'logo')->firstOrFail();

		$organization_image = new OrganizationImage();
		$organization_image->filename = $filename;

		$ori->save($organization, $organization_image, $image_type);
	}
}

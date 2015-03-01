<?php


namespace BookieGG\Services;


use BookieGG\Contracts\ImageManagerInterface;
use Intervention\Image\Image;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageManager implements ImageManagerInterface {

	public function storeLogo(UploadedFile $logo, $filename = null) {
		if($filename === null) {
			$filename = $this->generateLogoFilename(
				$logo->getClientOriginalName(), $logo->getClientOriginalExtension()
			);
		}
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

	public function generateLogoFilename($original_name, $filetype) {
		$name = preg_replace("/[^a-zA-Z0-9]+/", "", $original_name);

		return $name . "-" . md5(str_random(64)) . "." . $filetype;
	}
}
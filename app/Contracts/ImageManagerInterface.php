<?php


namespace BookieGG\Contracts;


use Intervention\Image\Image;
use Symfony\Component\HttpFoundation\File\UploadedFile;

interface ImageManagerInterface {
	public function storeLogo(UploadedFile $logo, $filename);
	public function resizeImageOnDisk(UploadedFile $logo);
	public function getGreatestDimension(Image $i);
}
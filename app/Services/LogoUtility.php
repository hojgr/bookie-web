<?php


namespace BookieGG\Services;


use BookieGG\Contracts\LogoUtilityInterface;

class LogoUtility implements LogoUtilityInterface {

	public function render($thing)
	{
		$logo = $thing->getLogo();

		if($logo === null)
			return "---";

		else {
			$link = $this->getLink($logo->filename);
			return $this->getImg($link, 32);
		}
	}

	public function renderBig($thing) {
		$logo = $thing->getLogo();

		$link = $this->getLink($logo->filename);
		return $this->getImg($link, 75);
	}

	public function renderSpecial($thing, $size) {
		$logo = $thing->getLogo();

		$link = $this->getLink($logo->filename);
		return $this->getImg($link, $size);
	}

	public function getLink($logo_filename) {
		return route('uploaded_asset', ['logo', 'organization', $logo_filename]);
	}

	public function getImg($url, $width, $height = null) {
		if($height === null)
			$height = $width;

		return "<img class='logo' style='width: " . $width . "px; height: ".  $height . "px' src='$url' alt='Logo' />";
	}
}

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
			$link = route('uploaded_asset', ['logo', 'organization', $logo->filename]);
			return "<img style='width: 32px; height: 32px' src='$link' alt='logo' />";
		}
	}
}
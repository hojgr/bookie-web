<?php


namespace BookieGG\Facades;


use Illuminate\Support\Facades\Facade;

class SteamUtil extends Facade {
	protected static function getFacadeAccessor() { return 'BookieGG\Contracts\SteamUtilityInterface'; }
}
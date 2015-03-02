<?php


namespace BookieGG\Facades;


use Illuminate\Support\Facades\Facade;

class TimeUtil extends Facade {
	protected static function getFacadeAccessor() {
		return 'BookieGG\Contracts\TimeUtilityInterface';
	}
}
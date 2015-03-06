<?php


namespace BookieGG\Facades;


use Illuminate\Support\Facades\Facade;

class Note extends Facade {
	protected static function getFacadeAccessor() {
		return 'BookieGG\Contracts\NoteHelperInterface';
	}
}
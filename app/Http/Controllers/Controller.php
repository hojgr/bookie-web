<?php namespace BookieGG\Http\Controllers;

use BookieGG\Contracts\Repositories\ArticleRepositoryInterface;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

abstract class Controller extends BaseController {

	use DispatchesCommands, ValidatesRequests;

	public function __construct(ArticleRepositoryInterface $ari) {
		// TODO: move to separate class ( http://laravel.com/docs/5.0/views#view-composers )
		\View::composer('app', function($v) use ($ari) {
			$v->with('articles', $ari->all());
		});
	}
}

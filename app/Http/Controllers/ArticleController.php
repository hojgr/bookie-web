<?php namespace BookieGG\Http\Controllers;

use BookieGG\Contracts\Repositories\ArticleRepositoryInterface;
use BookieGG\Http\Requests;

use Illuminate\Http\Request;

class ArticleController extends Controller {

	/**
	 * Display the specified resource.
	 *
	 * @param ArticleRepositoryInterface $ari
	 * @param  int $id
	 * @return Response
	 */
	public function show(ArticleRepositoryInterface $ari, $id)
	{
		return view('news/index')->with('article', $ari->find($id));
	}

}

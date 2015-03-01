<?php


namespace BookieGG\Repositories\Eloquent;


use BookieGG\Contracts\Repositories\ArticleRepositoryInterface;
use BookieGG\Models\Article;
use BookieGG\Models\User;

class ArticleRepository implements ArticleRepositoryInterface {


	public function find($id)
	{
		return Article::find($id);
	}

	public function all()
	{
		return Article::all();
	}

	public function save(User $author, Article $article)
	{
		$author->articles()->save($article);
	}
}
<?php


namespace BookieGG\Contracts\Repositories;


use BookieGG\Models\Article;
use BookieGG\Models\User;

interface ArticleRepositoryInterface {
	public function save(User $author, Article $article);
	public function find($id);
	public function all();
}
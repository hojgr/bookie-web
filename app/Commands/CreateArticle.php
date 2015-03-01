<?php namespace BookieGG\Commands;

use BookieGG\Commands\Command;

use BookieGG\Contracts\Repositories\ArticleRepositoryInterface;
use BookieGG\Models\Article;
use BookieGG\Models\User;
use Illuminate\Contracts\Bus\SelfHandling;

class CreateArticle extends Command implements SelfHandling {
	/**
	 * @var User
	 */
	private $author;
	/**
	 * @var
	 */
	private $title;
	/**
	 * @var
	 */
	private $text;

	/**
	 * Create a new command instance.
	 * @param User $author
	 * @param $title
	 * @param $text
	 */
	public function __construct(User $author, $title, $text)
	{
		//
		$this->author = $author;
		$this->title = $title;
		$this->text = $text;
	}

	/**
	 * Execute the command.
	 *
	 * @param ArticleRepositoryInterface $ari
	 */
	public function handle(ArticleRepositoryInterface $ari)
	{
		$article = new Article();

		$article->title = $this->title;
		$article->content = $this->text;

		$ari->save($this->author, $article);
	}

}

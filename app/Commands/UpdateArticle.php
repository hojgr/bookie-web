<?php namespace BookieGG\Commands;

use BookieGG\Contracts\Repositories\ArticleRepositoryInterface;
use Illuminate\Contracts\Bus\SelfHandling;

class UpdateArticle extends Command implements SelfHandling {
    /**
     * @var
     */
    private $id;
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
     *
     * @param $id
     * @param $title
     * @param $text
     */
    public function __construct($id, $title, $text)
    {
        //
        $this->id = $id;
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
        $article = $ari->find($this->id);

        $article->title = $this->title;
        $article->content = $this->text;

        $article->save();
    }

}

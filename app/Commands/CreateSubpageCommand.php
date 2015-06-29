<?php namespace BookieGG\Commands;


use BookieGG\Contracts\Repositories\SubpageRepositoryInterface;
use Illuminate\Contracts\Bus\SelfHandling;

class CreateSubpageCommand extends Command implements SelfHandling {
    /**
     * @var
     */
    private $name;
    /**
     * @var
     */
    private $content;

    /**
     * Create a new command instance.
     *
     * @param $name
     * @param $content
     */
    public function __construct($name, $content)
    {
        $this->name = $name;
        $this->content = $content;
    }

    /**
     * Execute the command.
     *
     * @param SubpageRepositoryInterface $sri
     */
    public function handle(SubpageRepositoryInterface $sri)
    {
        $sri->create($this->name, $this->content);
    }

}

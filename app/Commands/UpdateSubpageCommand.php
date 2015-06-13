<?php namespace BookieGG\Commands;

use BookieGG\Contracts\Repositories\SubpageRepositoryInterface;
use Illuminate\Contracts\Bus\SelfHandling;

class UpdateSubpageCommand extends Command implements SelfHandling {
	/**
	 * @var
	 */
	private $id;
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
	 * @param $id
	 * @param $name
	 * @param $content
	 */
	public function __construct($id, $name, $content)
	{
		//
		$this->id = $id;
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
		$subpage = $sri->find($this->id);

		$subpage->name = $this->name;
		$subpage->content = $this->content;

		$sri->save($subpage);
	}

}

<?php


namespace BookieGG\Repositories\Eloquent;


use BookieGG\Contracts\Repositories\SubpageRepositoryInterface;
use BookieGG\Subpage;

class SubpageRepository implements SubpageRepositoryInterface {

	public function create($name, $content)
	{
		$page = new Subpage();
		$page->name = $name;
		$page->content = $content;

		$page->save();
	}

	public function get($name)
	{
		return Subpage::where('name', '=', $name)->firstOrFail();
	}

	public function getAll()
	{
		return Subpage::all();
	}

	public function find($id) {
		return Subpage::find($id);
	}

	public function save(Subpage $sub) {
		$sub->save();
	}
}
<?php namespace BookieGG\Console\Commands\Item;

use BookieGG\Models\Csgo\CsgoItem;
use BookieGG\Models\Csgo\CsgoItemPrice;
use BookieGG\Models\Csgo\CsgoItemSkin;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ItemLookup extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'item:lookup';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Looks up items by given keywords';

	/**
	 * Create a new command instance.
	 *
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$keywords = explode(' ', $this->argument("keywords"));
		$item = $this->option('item');

		$data = null;

		$i = 0;
		foreach($keywords as $keyword) {
			if($i == 0) {
				$data = CsgoItemSkin::where('name', 'LIKE', "%$keyword%");
			} else {
				$data = $data->orWhere('name', 'LIKE', "%$keyword%");
			}
			$i++;
		}

		$tabular = [];

		foreach($data->orderBy('csgo_item_id', 'DESC')->get() as $d) {
			$itemname = $d->csgo_item->name;

			if($d->stattrak)
				$itemname = "StatTrak " . $itemname;

			if($d->souvenir)
				$itemname = "Souvenir " . $itemname;

			$tabular[] = [
				'item' => str_pad($itemname, 20, " ", STR_PAD_LEFT),
				'skin' => $d->name
			];
		}

		$this->table(['item', 'skin'], $tabular);
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [
			['keywords', InputArgument::REQUIRED, 'Keywords'],
		];
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return [
			['item', 'i', InputArgument::REQUIRED, 'Item name/keyword'],
		];
	}

}

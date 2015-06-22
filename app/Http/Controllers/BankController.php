<?php


namespace BookieGG\Http\Controllers;

use BookieGG\Models\CsgoItem;
use BookieGG\Models\CsgoItemPrice;
use BookieGG\Repositories\Eloquent\BankRepository;
use BookieGG\Contracts\InventoryLoaderInterface;
use BookieGG\Services\ItemUtility;

class BankController extends Controller {
    public function show(
        BankRepository $bankRepository, 
        InventoryLoaderInterface $inventoryLoader,
        ItemUtility $itemUtil 
    ) {

		$bankItems = $bankRepository->getBank(\Auth::getUser());

		// generate bank
		$bank = [];
		foreach($bankItems as $bankItem) {
			$bank[] = (object) [
				"id" => $bankItem->id,
				"weaponName" => $bankItem->csgo_item->market_name,
				"exterior" => $bankItem->csgo_item->csgo_item_exterior->name,
				"quality" =>  $bankItem->csgo_item->csgo_item_quality->name,
				"price" => $bankItem->csgo_item->latestPrice->price,
				"stattrak" => $bankItem->csgo_item->stattrak == 1,
				"image" => $bankItem->csgo_item->getLogoURL()
			];
		}

		usort($bank, function($a,$b) {
			if ($a->price == $b->price) { return 0; }

			if(floatval($b->price) > floatval($a->price))
				return 1;

			return -1;
		});

		return view("bank/bank")
			->with('userInventory', $inventoryLoader->loadSteamInventory(\Auth::getUser()->steam_id))
			->with('userBank', $bank);
	}
}

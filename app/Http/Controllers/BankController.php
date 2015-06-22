<?php

namespace BookieGG\Http\Controllers;

use BookieGG\Models\CsgoItem;
use BookieGG\Models\CsgoItemPrice;
use BookieGG\Repositories\Eloquent\BankRepository;
use BookieGG\Contracts\InventoryLoaderInterface;
use BookieGG\Contracts\BankLoaderInterface;
use BookieGG\Services\ItemUtility;

class BankController extends Controller {
    public function show(
        InventoryLoaderInterface $inventoryLoader,
        BankLoaderInterface $bankLoader
    ) {
		return view("bank/bank")
			->with('userInventory', $inventoryLoader->loadSteamInventory(\Auth::getUser()->steam_id))
			->with('userBank', $bankLoader->load(\Auth::getUser()));
	}
}

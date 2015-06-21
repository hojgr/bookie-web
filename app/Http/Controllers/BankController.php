<?php


namespace BookieGG\Http\Controllers;

use BookieGG\Models\CsgoItem;
use BookieGG\Models\CsgoItemPrice;
use BookieGG\Repositories\Eloquent\BankRepository;

class BankController extends Controller {
	public function show(BankRepository $bankRepository) {

		$inventoryJsonURL = "http://steamcommunity.com/profiles/" . \Auth::getUser()->steam_id . "/inventory/json/730/2";
		$inventoryJsonString = file_get_contents($inventoryJsonURL);
		$inventoryJson = json_decode($inventoryJsonString);

		$qualities = ["Factory New", "Minimal Wear", "Field-Tested", "Well-Worn", "Battle-Scarred"];

		$getQuality = function($market_name) use ($qualities) {
			foreach($qualities as $quality) {
				if(str_contains($market_name, $quality))
					return $quality;
			}

			return "";
		};

		$inv = [];
		$names = [];
		foreach($inventoryJson->rgInventory as $item) {

			$itemDescription = $inventoryJson->rgDescriptions->{$item->classid . "_" . $item->instanceid};

			if(!$itemDescription->tradable)
				continue;

			$names[] = $itemDescription->market_hash_name;
			$inv[] = (object) [
				"id" => $item->id, // this is used as index for all POST params - must be unique for inventory
				"weaponName" => $itemDescription->market_hash_name,
				"exterior" => $getQuality($itemDescription->market_hash_name),
				"quality" =>  $itemDescription->type,
				"price" => "??",
				"stattrak" => str_contains($itemDescription->market_hash_name, "StatTrak"),
				"image" => "http://steamcommunity-a.akamaihd.net/economy/image/" . $itemDescription->icon_url . "/90fx60f",
				"steam_info" => [
					"id" => $item->id,
					"class_id" => $item->classid,
					"instance_id" => $item->instanceid,
				]
			];
		}

		$prices = CsgoItem::whereIn('market_name', $names)->get()->keyBy("market_name");

		foreach($inv as $id => $item) {
			if(!isset($prices[$item->weaponName])) {
				unset($inv[$id]);
			} else {
				$item->price = $prices[$item->weaponName]->latestPrice->price;
			}
		}


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

		// sort inventory & bank by exterior
		// this shouldn't happen in the controller
		usort($inv, function($a,$b) {
			if ($a->price == $b->price) { return 0; }

			if(floatval($b->price) > floatval($a->price))
				return 1;

			return -1;
		});

		usort($bank, function($a,$b) {
			if ($a->price == $b->price) { return 0; }

			if(floatval($b->price) > floatval($a->price))
				return 1;

			return -1;
		});

		return view("bank/bank")
			->with('userInventory', $inv)
			->with('userBank', $bank);
	}
}

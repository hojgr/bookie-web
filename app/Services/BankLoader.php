<?php

namespace BookieGG\Services;

use BookieGG\Contracts\BankLoaderInterface;
use BookieGG\Models\User;
use BookieGG\Repositories\Eloquent\BankRepository;

class BankLoader implements BankLoaderInterface {
    public function __construct(BankRepository $bankRepository) {
        $this->bankRepository = $bankRepository;
    }

    function load(User $user) {
		$bankItems = $this->bankRepository->getBank(\Auth::getUser());

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

        return $bank;
    }
}

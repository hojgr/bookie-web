<?php


namespace BookieGG\Http\Controllers;

use BookieGG\Repositories\Eloquent\BankRepository;

class BankController extends Controller {
	public function show(BankRepository $bankRepository) {
		$weapons = [
			'http://steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz56P7fiDzRyTQXJVfdhX_o45gnTBCI24dJua9u35bwDZw2-tYrFNeMvMNhIG8OEXvKBYQGrvhg-g6AMe8eMpni93y7rbGZeCEH1ujVTFsKH5xI/90fx60f',
			'https://steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz58OOy2OwhkZzvFDa9dV7g2_Rn5DDQx7cl3a9u_8LMSZw3qtdfPNrR5ZNwdSpbSUqXVNQz4vktr0aUPK5bYp37m2yntbG0MCkD1ujVTR3uA_-U/90fx60f',
			'http://steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz56I_OKMyJYdAXUBKxfY_Qt5DfhDCM7_cpcWNak8L5IfgnovNDCZ7MuM9sfTsmEW6OCYVqr70pthvcJLZPf8inn3Snha2tYCg2rpDwNRl310w/90fx60f',
			'http://steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz56I_OKOC5YcAjDDJ9NVfgq-A3TBS414NNcWNak8L5ILFjutYbPN7coONkZH8PWXKSENV2o6kI60akJe8TapH7o3yjpPWkPCQ2rpDzhF3nw7A/90fx60f',
			'http://steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz5oN-KnYmdYcRH9EqNfTso57RrpERg-4cBrQOi69qkBLBLpsYCQYrAkZIseG8fWCKTXMFr-70pt1aYLep2JqSu63CS7PW5eDxLt5Ctaz6ReUTeC/90fx60f',
			'http://steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz5jObLlYWNYcRH9Ga0PDKRuywvtGy4m6dRcWdKy_q4LFlC-9tWTLeF_MdxIGcLSWKWDZQmp6B46g6YOL5Pa9Cvr2S-4OW9YUkbu_GpXzeaZ-uw8QCCaCjI/90fx60f',
			'http://steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz5oN-KnYmdYcRH9EqNfTso57RrpERg-4cBrQOi69qkBLBLpsYCQYrAkZIseG8fWCKTXMFr-70pt1aYLep2JqSu63CS7PW5eDxLt5Ctaz6ReUTeC/90fx60f',
			'http://steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz52YOLkDyRufgHMAqVMY_Q3ywW4CHZ_-_hiWNu57oQJO12x49epb-l7aJwjQ5GSDaOYbguvvkk_gvVdLZCP9ivoiH_hPG4IUkLjrmoAmefUvudu0DkUESK5_vLM95cjMz2U1Q/90fx60f',
			'http://steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz52YOLkDzRyTQmWAPRhXfs58Rv4GyY-18pmUN6j-oQKKE644ZyQMOUqZtAaHJaFWvGCZV_66k1qiPQMK5OA9C_m3ijubDpZDRPi-z1QhqbZ7Qj0BpNT/90fx60f',
			'http://steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz52YOLkDyRufgHMAqVMY_Q3ywW4CHZ_-_hiWNu57oQJO12x49epbuV4aZ0RcJyBGKHTeAv77x44gqUJfcPYoi6-3C3hOmpeU0fi-DhXy7TT7rpvizlHRSey-eSS6Z6uOk_crRE/90fx60f',
		];
		$qualities = ["Consumer", "Industrial", "Mil-Spec", "Restricted", "Classified", "Covert", "Melee", "Contraband"];

		// generate inventory
		$invLength = rand(1,20);
		$inv = [];
		for ($i = 0; $i < $invLength; $i++) {
			$inv[] = (object) [
				"id" => 1, // this is used as index for all POST params - must be unique for inventory
				"weaponName" => "AK-47 | Serpent Ward (Battle-Scarred)",
				"exterior" => ["Factory New", "Minimal Wear", "Field-Tested", "Well-Worn", "Battle-Scarred"][rand(0,4)],
				"quality" =>  $qualities[rand(0,7)],
				"price" => "60.00",
				"stattrak" => !rand(0,1),
				"image" => $weapons[rand(0,9)],
				"steam_info" => [
					"id" => "1234567890",
					"context_id" => "4",
					"instance_id" => "321",
					"asset_id" => "123"
				]
			];
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
			$qualities = ["Consumer", "Industrial", "Mil-Spec", "Restricted", "Classified", "Covert", "Melee", "Contraband"];
			if ($a->quality == $b->quality) { return 0; }

			return array_search($b->quality, $qualities) - array_search($a->quality, $qualities);
		});
		usort($bank, function($a,$b) {
			$qualities = ["Consumer", "Industrial", "Mil-Spec", "Restricted", "Classified", "Covert", "Melee", "Contraband"];
			if ($a->quality == $b->quality) { return 0; }

			return array_search($b->quality, $qualities) - array_search($a->quality, $qualities);
		});

		return view("bank/bank")
			->with('userInventory', $inv)
			->with('userBank', $bank);
	}
}

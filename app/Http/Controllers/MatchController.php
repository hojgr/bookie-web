<?php


namespace BookieGG\Http\Controllers;


use BookieGG\Contracts\Repositories\MatchRepositoryInterface;

class MatchController extends Controller {
	public function show(MatchRepositoryInterface $mri, $id) {
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

		$streams = [
			"English" => "http://www.twitch.tv/faceittv/embed",
			"Russian" => "http://www.twitch.tv/steel_tv/embed",
			"German" => "http://www.hitbox.tv/embed/coolexit"
		];

		// generate user's inventory placeholder
		$qualities = ["Consumer", "Industrial", "Mil-Spec", "Restricted", "Classified", "Covert", "Melee", "Contraband"];
		
		// generate inventory
		$invLength = rand(1,20);
		$inv = [];
		for ($i = 0; $i < $invLength; $i++) {
			$inv[] = (object) [
				"id" => 1,
				"weaponName" => "AK-47 | Serpent Ward (Battle-Scarred)",
				"exterior" => ["Factory New", "Minimal Wear", "Field-Tested", "Well-Worn", "Battle-Scarred"][rand(0,4)],
				"quality" =>  $qualities[rand(0,7)],
				"price" => "60.00",
				"stattrak" => !rand(0,1),
				"image" => $weapons[rand(0,9)]
			];
		}

		// generate bet
		$betLength = rand(0,10);
		$bet = [];
		for ($i = 0; $i < $betLength; $i++) {
			$bet[] = (object) [
				"id" => 1,
				"weaponName" => "AK-47 | Serpent Ward (Battle-Scarred)",
				"exterior" => ["Factory New", "Minimal Wear", "Field-Tested", "Well-Worn", "Battle-Scarred"][rand(0,4)],
				"quality" =>  $qualities[rand(0,7)],
				"price" => "60.00",
				"stattrak" => !rand(0,1),
				"image" => $weapons[rand(0,9)]
			];
		}
		$userBet = (object) [
			"items" => $bet,
			"team" => 0,
			"id" => 237
		];

		// sort inventory & bank by exterior
		// this shouldn't happen in the controller
		usort($inv, function($a,$b) {
			$qualities = ["Consumer", "Industrial", "Mil-Spec", "Restricted", "Classified", "Covert", "Melee", "Contraband"];
			if ($a->quality == $b->quality) { return 0; }

			return array_search($b->quality, $qualities) - array_search($a->quality, $qualities);
		});
		
		return view("match/match")
			->with('match', $mri->find($id))
			->with('weapons', $weapons)
			->with('streams', $streams)
			->with('userBet', $userBet)
			->with('userInv', $inv);
	}
}

<?php

namespace BookieGG\Services;

class InventoryLoader {
    function load($steamId64) {
		$inventoryJsonURL = "http://steamcommunity.com/profiles/" . \Auth::getUser()->steam_id . "/inventory/json/730/2";
		$inventoryJsonString = file_get_contents($inventoryJsonURL);
		$inventoryJson = json_decode($inventoryJsonString);

        return $inventoryJson;
    }
}

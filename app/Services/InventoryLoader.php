<?php

namespace BookieGG\Services;

use BookieGG\Contracts\ItemUtilityContract;
use BookieGG\Models\CsgoItem;
use BookieGG\Contracts\InventoryLoaderInterface;

class InventoryLoader implements InventoryLoaderInterface {

    /** @var ItemUtilityContract */
    protected $itemUtility;

    public function __construct(ItemUtilityContract $itemUtil) {
        $this->itemUtility = $itemUtil;
    }

    public function loadSteamInventoryJSON($steamId64) {
        $inventoryJsonURL = "http://steamcommunity.com/profiles/" . $steamId64 . "/inventory/json/730/2";
        $inventoryJsonString = file_get_contents($inventoryJsonURL);
        $inventoryJson = json_decode($inventoryJsonString);

        return $inventoryJson;
    }

    public function loadSteamInventory($steamId64) {
        $inventoryJson = $this->loadSteamInventoryJSON($steamId64);

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
                "exterior" => $this->itemUtility->getExterior($itemDescription->market_hash_name),
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

        usort($inv, function($a,$b) {
            if ($a->price == $b->price) { return 0; }

            if(floatval($b->price) > floatval($a->price))
                return 1;

            return -1;
        });

        return $inv;
    }
}

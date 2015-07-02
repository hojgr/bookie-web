<?php
/**
 * Inventory Loader
 *
 * PHP version 5.6
 *
 * @category Class
 * @package  BookieGG\Services
 * @author   Michal Hojgr <michal.hojgr@gmail.com>
 * @author   Johan Fagerberg <not@known.com>
 * @license  MS Reference
 * @link     http://bookie.gg
 */

namespace BookieGG\Services;

use BookieGG\Contracts\ItemUtilityContract;
use BookieGG\Models\CsgoItem;
use BookieGG\Contracts\InventoryLoaderInterface;

/**
 * InventoryLoader
 *
 * @category Class
 * @package  BookieGG\Services
 * @author   Michal Hojgr <michal.hojgr@gmail.com>
 * @license  MS Reference
 * @link     http://bookie.gg
 */
class InventoryLoader implements InventoryLoaderInterface
{

    /**
     * Item utility
     *
     * @var ItemUtilityContract item utility
     */
    protected $itemUtility;

    /**
     * Constructor
     *
     * @param ItemUtilityContract $itemUtil contract
     */
    public function __construct(ItemUtilityContract $itemUtil)
    {
        $this->itemUtility = $itemUtil;
    }

    /**
     * Loads steam inventory of given steam id
     *
     * Does do caching
     *
     * @param string $steamId64      Id of which to get
     * @param array  $pendingDeposit Pending deposit
     *
     * @return object Object
     */
    public function getSteamInventory($steamId64, $pendingDeposit)
    {
        return $this->loadSteamInventory($steamId64, $pendingDeposit);

        $cacheKey = 'steam_inventory:' . $steamId64;

        if (!\Cache::has($cacheKey)) {
            $inventory = $this->loadSteamInventory($steamId64);
            \Cache::put($cacheKey, $inventory, 1);

            return $inventory;
        }

        return \Cache::get($cacheKey);
    }

    /**
     * Invalidate cache of given steamId
     *
     * Made to invalidate cache after known inventory manipulation
     * such as finished trade etc.
     *
     * @param string $steamId64 Steam ID
     *
     * @return void
     */
    public function invalidateCache($steamId64)
    {
        
    }

    /**
     * Loads JSON of given id
     *
     * @param string $steamId64 Id of user to be loaded
     *
     * @return json Json of steamid's inventory
     */
    private function loadSteamInventoryJSON($steamId64)
    {
        $inventoryJsonURL = "http://steamcommunity.com/profiles/"
            . $steamId64
            . "/inventory/json/730/2";

        $inventoryJsonString = file_get_contents($inventoryJsonURL);
        $inventoryJson = json_decode($inventoryJsonString);

        return $inventoryJson;
    }

    /**
     * Loads user's inventory into an frontend object
     *
     * Does not do caching
     *
     * @param string $steamId64      Id of user to be loaded
     * @param array  $pendingDeposit Pending deposit
     *
     * @return object Object
     */
    private function loadSteamInventory($steamId64, $pendingDeposit)
    {
        $inventoryJson = $this->loadSteamInventoryJSON($steamId64);

        $inv = [];
        $invPending = [];
        
        $names = [];
        foreach ($inventoryJson->rgInventory as $item) {
            $jsonKey = $item->classid . "_" . $item->instanceid;
            $itemDescription = $inventoryJson->rgDescriptions->$jsonKey;

            if (!$itemDescription->tradable) {
                continue;
            }

            $names[] = $itemDescription->market_hash_name;

            $exterior = $this->itemUtility->getExterior(
                $itemDescription->market_hash_name
            );

            $isStattrak = str_contains(
                $itemDescription->market_hash_name,
                "StatTrak"
            );

            $currentItem = (object) [
                "id" => $item->id, // this is used as index for all POST params
                "weaponName" => $itemDescription->market_hash_name,
                "exterior" => $exterior,
                "quality" =>  $itemDescription->type,
                "price" => "??",
                "stattrak" => $isStattrak,
                "image" => "http://steamcommunity-a.akamaihd.net/economy/image/"
                    . $itemDescription->icon_url
                . "/90fx60f",
                "steam_info" => [
                    "id" => $item->id,
                    "class_id" => $item->classid,
                    "instance_id" => $item->instanceid,
                ]
            ];

            if (in_array($item->id, $pendingDeposit)) {
                $invPending[] = $currentItem;
            } else {
                $inv[] = $currentItem;
            }
        }

        $prices = CsgoItem::whereIn('market_name', $names)
            ->get()
            ->keyBy("market_name");

        foreach ($inv as $id => $item) {
            if (!isset($prices[$item->weaponName])) {
                unset($inv[$id]);
                continue;
            }

            $item->price = $prices[$item->weaponName]->latestPrice->price;
        }

        foreach ($invPending as $id => $item) {
            if (!isset($prices[$item->weaponName])) {
                unset($inv[$id]);
                continue;
            }

            $item->price = $prices[$item->weaponName]->latestPrice->price;
        }

        usort(
            $inv,
            function ($a, $b) {
                if ($a->price == $b->price) {
                    return 0;
                }

                if (floatval($b->price) > floatval($a->price)) {
                    return 1;
                }

                return -1;
            }
        );

        usort(
            $invPending,
            function ($a, $b) {
                if ($a->price == $b->price) {
                    return 0;
                }

                if (floatval($b->price) > floatval($a->price)) {
                    return 1;
                }

                return -1;
            }
        );

        return [$inv, $invPending];
    }
}

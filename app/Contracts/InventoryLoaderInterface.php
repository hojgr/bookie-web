<?php

namespace BookieGG\Contracts;

interface InventoryLoaderInterface {
    /**
     * Loads items from user's inventory
     * on steam page
     */
    public function loadSteamInventoryJSON($steamId64);

    /**
     * Parses steam inventory json to our
     * object format
     */
    public function loadSteamInventory($steamId64);
}

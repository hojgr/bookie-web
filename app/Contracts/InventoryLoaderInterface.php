<?php

namespace BookieGG\Contracts;

interface InventoryLoaderInterface
{
    /**
     * Loads items from user's inventory
     * on steam page
     */
    public function getSteamInventory($steamId64);
}

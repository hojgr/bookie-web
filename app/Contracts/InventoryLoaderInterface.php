<?php

namespace BookieGG\Contracts;

interface InventoryLoaderInterface
{
    /**
     * Loads items from user's inventory
     * on steam page
     */
    public function getSteamInventory($steamId64, $depositPending);

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
    public function invalidateCache($steamId64);
}

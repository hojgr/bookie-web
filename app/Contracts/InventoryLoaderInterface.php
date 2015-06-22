<?php

namespace BookieGG\Contracts;

interface InventoryLoaderInterface {
    function load($steamId64);
}

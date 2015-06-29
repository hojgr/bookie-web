<?php

namespace BookieGG\Services;

use BookieGG\Contracts\ItemUtilityContract;

class ItemUtility implements ItemUtilityContract {
    const qualities = ["Factory New", "Minimal Wear", "Field-Tested", "Well-Worn", "Battle-Scarred"];

    /**
     * Returns an exterior from a makret name
     * @return string exterior
     */
    public function getExterior($market_name) {
        foreach(self::qualities as $quality) {
            if(str_contains($market_name, $quality))
                return $quality;
        }
        return "";
    }
}


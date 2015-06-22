<?php

namespace BookieGG\Contracts;

interface ItemUtilityContract {
    /**
     * Returns an exterior from a makret name
     * @return string exterior
     */
    public function getExterior($market_name);
}

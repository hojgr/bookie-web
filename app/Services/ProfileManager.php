<?php
/**
 * Service for handling all profile related actions
 *
 * PHP version 5.6
 *
 * @category Class
 * @package  BookieGG\Services
 * @author   Michal Hojgr <michal.hojgr@gmail.com>
 * @license  MS Reference
 * @link     http://bookie.gg
 */

namespace BookieGG\Services;

/**
 * Profile Service
 *
 * @category Class
 * @package  BookieGG\Services
 * @author   Michal Hojgr <michal.hojgr@gmail.com>
 * @license  MS Reference
 * @link     http://bookie.gg
 */
class ProfileManager
{
    const TRADE_URL_REGEX = '~(?:https?://)?steamcommunity.com/tradeoffer/new/\?partner=([0-9]+)&token=([0-9a-zA-Z]+)~';

    /**
     * Validas wether or not given URL is valid trade link
     *
     * @param string $url Trade url
     *
     * @return bool
     */
    public function isTradeURLValid($url)
    {
        return preg_match(self::TRADE_URL_REGEX, $url) === 1;
    }
}

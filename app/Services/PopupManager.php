<?php
/**
 * Handles popups
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

use BookieGG\Models\User;
use BookieGG\Services\TradeManager;

class PopupManager
{
    public function hasActivePopup(User $user)
    {
        $userTrade = $user->user_last_trade;

        if (!$userTrade) {
            return false;
        }

        if ($userTrade->status === TradeManager::STATUS_ACTIVE) {
            return true;
        }

        if ($userTrade->status === TradeManager::STATUS_QUEUE) {
            return true;
        }
    }
}

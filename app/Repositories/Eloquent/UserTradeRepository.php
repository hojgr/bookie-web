<?php
/**
 * Repository responsible for UserTrade db actions
 *
 * PHP version 5.6
 *
 * @category Class
 * @package  BookieGG\Repositories\Eloquent
 * @author   Michal Hojgr <michal.hojgr@gmail.com>
 * @license  MS Reference
 * @link     http://bookie.gg
 */

namespace BookieGG\Repositories\Eloquent;

use BookieGG\Models\UserTrade;
use BookieGG\Models\User;
use BookieGG\Models\UserTradeDepositItem;

/**
 * Repository
 *
 * @category Class
 * @package  BookieGG\Repositories\Eloquent
 * @author   Michal Hojgr <michal.hojgr@gmail.com>
 * @license  MS Reference
 * @link     http://bookie.gg
 */
class UserTradeRepository
{
    /**
     * Create db record for trade deposit
     *
     * @param User  $user  User that wants the trade
     * @param array $items items to be deposited
     *
     * @return void
     */
    public function createTradeDeposit(User $user, $items)
    {
        $trade = new UserTrade;
        $trade->type = "deposit";
        $trade->user_id = $user->id;
        $trade->status = "queue";
        $trade->save();

        foreach ($items as $item) {
            $dbItem = new UserTradeDepositItem();

            $dbItem->user_trade_id = $trade->id;
            $dbItem->steam_item_id = $item['id'];
            $dbItem->class_id = $item['class_id'];
            $dbItem->instance_id = $item['instance_id'];

            $dbItem->save();
        }
    }
}

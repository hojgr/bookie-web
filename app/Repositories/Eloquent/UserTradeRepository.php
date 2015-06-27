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
     * @param User   $user         User that wants the trade
     * @param string $redisTradeId An integer trade was set into redis with
     * @param array  $items        items to be deposited
     *
     * @return void
     */
    public function createTradeDeposit(User $user, $redisTradeId, $items)
    {
        $trade = new UserTrade;
        $trade->type = "deposit";
        $trade->user_id = $user->id;
        $trade->redis_trade_id = $redisTradeId;
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

    /**
     * Returns all pending trades
     *
     * @param User $user User for which to get itt
     *
     * @return array
     */
    public function getPendingTrade(User $user)
    {
        $trade = UserTrade::where('user_id', '=', $user->id)->where(
            function ($q) {
                $q->whereIn('status', ['queue', 'active']);
            }
        )->get()->last();

        if ($trade === null) {
            return [[], []];
        }

        if ($trade->type == "deposit") {
            $items = [];
            
            foreach ($trade->user_trade_deposit_items as $tradeDepositItem) {
                $items[] = [
                    'id' => $tradeDepositItem->steam_item_id,
                    'class_id' => $tradeDepositItem->class_id,
                    'instance_id' => $tradeDepositItem->instance_id
                ];
            }

            // the expected return value is [pendingDeposit, pendingWithdraw]
            return [$items, []];
        }
        throw new \Exception("Not implemented");
    }

    /**
     * Finds a trade by redis id
     *
     * @param int $redisId Redis id
     *
     * @return \BookieGG\Models\UserTrade
     */
    public function get($redisId)
    {
        return UserTrade::where('redis_trade_id', '=', $redisId)->firstOrFail();
    }
}

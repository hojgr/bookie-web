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
use BookieGG\Models\UserBank;
use BookieGG\Models\UserTradeWithdrawItem;
use BookieGG\Services\TradeManager;

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
     * Create db record for trade deposit
     *
     * @param User   $user         User that wants the trade
     * @param string $redisTradeId An integer trade was set into redis with
     * @param array  $items        items to be deposited
     *
     * @return void
     */
    public function createTradeWithdraw(User $user, $redisTradeId, $items)
    {
        $trade = new UserTrade;
        $trade->type = "withdraw";
        $trade->user_id = $user->id;
        $trade->redis_trade_id = $redisTradeId;
        $trade->status = "queue";
        $trade->save();

        $dbItems = UserBank::whereIn('id', $items)
            /*
             * This is the only check to prevent item stealing!
             * There should be some better system to prevent future vulnerabilities
             * ... or tests
             */
            ->where('user_id', '=', $user->id)
            ->get();

        $items = [];
        foreach ($dbItems as $item) {
            $dbItem = new UserTradeWithdrawItem();

            $dbItem->user_trade_id = $trade->id;
            $dbItem->user_bank_id = $item->id;

            $dbItem->save();

            $items[] = $dbItem;
        }

        return $items;
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
                $items[] = $tradeDepositItem->steam_item_id;
            }

            // the expected return value is [pendingDeposit, pendingWithdraw]
            return [$items, []];
        } elseif ($trade->type == "withdraw") {
            $items = [];

            foreach ($trade->user_trade_withdraw_items as $tradeWithdrawItem) {
                $items[] = $tradeWithdrawItem->user_bank_id;
            }

            return [[], $items];
        }
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

    /**
     * Returns where there is user's trade in queue
     *
     * @param User $user
     *
     * @return integer position
     */
    public function getQueuePosition(User $user)
    {
        $userTrade = $user->user_last_trade;

        if ($userTrade->status !== TradeManager::STATUS_QUEUE) {
            return false;
        }

        $count = UserTrade::where('status', '=', TradeManager::STATUS_QUEUE)
            ->where('id', '<=', $userTrade->id)->count();

        return $count;
    }
}

<?php /** * A class that manages Customer trades
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

use Illuminate\Redis\Database;
use BookieGG\Repositories\Eloquent\UserTradeRepository;
use BookieGG\Models\RedisTradeStatus;
use BookieGG\Models\CsgoItem;
use BookieGG\Models\UserTrade;
use BookieGG\Models\UserBank;

/**
 * A clas that manager customer trades
 *
 * @category Class
 * @package  BookieGG\Services
 * @author   Michal Hojgr <michal.hojgr@gmail.com>
 * @license  MS Reference
 * @link     http://bookie.gg
 */
class TradeManager
{
    const STATUS_QUEUE = "queue";
    const STATUS_ACTIVE = "active";
    const STATUS_CANCELLED = "cancelled";
    const STATUS_ACCEPTED = "accepted";
    /**
     * Redis connection
     *
     * @var Redis
     */
    protected $redis;

    /**
     * User Trade repo
     *
     * @var UserTradeRepository
     */
    protected $tradeRepo;

    /**
     * Constructor
     *
     * @param Database            $redis     Redis connection
     * @param UserTradeRepository $tradeRepo User Trade Repository
     */
    public function __construct(Database $redis, UserTradeRepository $tradeRepo)
    {
        $this->redis = $redis;
        $this->tradeRepo = $tradeRepo;
    }

    /**
     * Sets status of trade
     *
     * @param RedisTradeStatus $redisTrade Redis trade
     * @param string           $status     Status to be set
     *
     * @return void
     */
    public function setStatus(RedisTradeStatus $redisTrade, $status)
    {
        $dbTrade = $this->tradeRepo->get($redisTrade->redisId);

        $dbTrade->status = $status;
        $dbTrade->save();
    }

    /**
     * Assign items from $redisTrade->itemNames to user's Bank
     *
     * @param UserTrade        $userTrade  DB Trade info
     * @param RedisTradeStatus $redisTrade Redis trade info
     *
     * @return void
     */
    public function assignItems(UserTrade $userTrade, RedisTradeStatus $redisTrade)
    {
        // does lookup, doesnt assign correctly!
        $dbItems = CsgoItem::whereIn('market_name', $redisTrade->itemNames)->get()->keyBy('market_name');

        $insertData = [];

        /*
         * We iterate over $redisTrade->itemNames 
         * as it has ALL the items. The $dbItems has only
         * each item once. After the item from DB is queried,
         * we iterate over $redisTrade->itemNames and pick
         * the item from array.
         *
         * Otherwise when user is depositing 2 items
         * of same name (and quality) he receives it only once in bank
         */
        foreach ($redisTrade->itemNames as $itemName) {
            $insertData[] = [
                'user_id' => $userTrade->user_id,
                'csgo_item_id' => $dbItems[$itemName]->id,
                'created_at' => date('Y-m-d H-i-s'),
                'updated_at' => date('Y-m-d H-i-s')
            ];
        }

        UserBank::insert($insertData);
    }

    /**
     * Remove items from user's bank
     *
     * @param UserTrade        $userTrade  DB Trade info
     * @param RedisTradeStatus $redisTrade Redis trade info
     *
     * @return void
     */
    public function removeItems(UserTrade $userTrade, RedisTradeStatus $redisTrade)
    {
        $idsToDelete = $userTrade->user_trade_withdraw_items->map(
            function ($a) {
                return $a->user_bank_id;
            }
        );

        UserBank::whereIn('id', $idsToDelete->toArray())->delete();
    }
}

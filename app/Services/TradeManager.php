<?php
/**
 * A class that manages Customer trades
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
        $dbItems = CsgoItem::whereIn('market_name', $redisTrade->itemNames)->get();

        $insertData = [];
        foreach ($dbItems as $dbItem) {
            $insertData[] = [
                'user_id' => $userTrade->user_id,
                'csgo_item_id' => $dbItem->id,
                'created_at' => date('Y-m-d H-i-s'),
                'updated_at' => date('Y-m-d H-i-s')
            ];
        }

        UserBank::insert($insertData);
    }
}

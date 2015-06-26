<?php
/**
 * A class that handles all redis trade loading
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
use BookieGG\Models\TradeStatus;

/**
 * Class handling Redis trades
 *
 * PHP version 5.6
 *
 * @category Class
 * @package  BookieGG\Services
 * @author   Michal Hojgr <michal.hojgr@gmail.com>
 * @license  MS Reference
 * @link     http://bookie.gg
 */
class RedisTrades
{

    /**
     * Redis connection
     *
     * @var Redis $redis
     */
    public $redis;

    /**
     * Constructor
     *
     * @param Database $redis Redis connection
     *
     * @return void
     */
    public function __construct(Database $redis)
    {
        $this->redis = $redis;
    }

    /**
     * Yields all trade:*:status
     *
     * @return void
     */
    public function eachTrade()
    {
        $tradeKeys = $this->redis->keys('trade:status:*');
        foreach ($tradeKeys as $tradeKey) {
            preg_match("/trade:status:([0-9]+)/", $tradeKey, $matches);

            $redisId = $matches[1];

            $trade = $this->redis->hmget(
                $tradeKey,
                "tradeofferid",
                "status",
                "items"
            );

            $tradeStatus = new TradeStatus(
                (int)$redisId,
                $trade[0],
                json_decode($trade[2]),
                $trade[1]
            );

            yield $tradeStatus;
        }
    }
}

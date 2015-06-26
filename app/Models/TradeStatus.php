<?php
/**
 * A class that contains status constants
 *
 * PHP version 5.6
 *
 * @category Class
 * @package  BookieGG\Models
 * @author   Michal Hojgr <michal.hojgr@gmail.com>
 * @license  MS Reference
 * @link     http://bookie.gg
 */
namespace BookieGG\Models;

/**
 * A class that contains statuses
 *
 * The statuses MUST be strings (that's what Redis returns)
 * If they are not strings, === comparison will eval to false
 *
 * @category Class
 * @package  BookieGG\Models
 * @author   Michal Hojgr <michal.hojgr@gmail.com>
 * @license  MS Reference
 * @link     http://bookie.gg
 */
class TradeStatus
{
    const ACCEPTED = "3";
    const PENDING = "2";
    const CANCELLED = "-1";

    /**
     * ID that status/offer is stored under
     *
     * Such as trade:offer:$redisId and trade:status:$redisId
     *
     * @var int (must be casted from redis explicitly)
     */
    protected $redisId;

    /**
     * ID of real tradeoffer on the Steam platform
     *
     * @var string (too long for 32 bit int)
     */
    protected $tradeOfferId;

    /**
     * Array of names this trade concerns
     *
     * @var string[]
     */
    protected $itemNames;

    /**
     * Status of this trade
     *
     * Status is not well defined as of the time of writing.
     * Generally it matches Steam's statuses but right now
     * it supports only ACCEPTED, PENDING, OTHER(cancelled),
     * 3, 2, -1 respectetivly.
     *
     * The other/cancelled might and most likely will change.
     *
     * @var string (really, that's because redis provides it)
     */
    protected $status;

    /**
     * Constructor!
     *
     * Everything is string, because that's what
     * redis returns as of now
     *
     * @param string $redisId      ID in redis
     * @param string $tradeOfferId ID on steam platform
     * @param string $itemNames    Array of items that is being manipulated
     * @param string $status       Status of trade
     */
    public function __construct($redisId, $tradeOfferId, $itemNames, $status)
    {
        $this->redisId = $redisId;
        $this->tradeOfferId = $tradeOfferId;
        $this->itemNames = $itemNames;
        $this->status = $status;
    }

    /**
     * Checks wether trade is pending
     *
     * @return bool Is pending?
     */
    public function isPending()
    {
        return $this->status === self::PENDING;
    }

    /**
     * Checks wether trade is cancelled
     *
     * @return bool Is pending?
     */
    public function isCancelled()
    {
        return $this->status === self::CANCELLED;
    }

    /**
     * Checks if trade is accepted
     *
     * @return bool Is accepted?
     */
    public function isAccepted()
    {
        return $this->status == self::ACCEPTED;
    }
}

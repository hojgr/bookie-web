<?php
/**
 * Model for items to be withdrawn
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

use Illuminate\Database\Eloquent\Model;

/**
 * Model for items to be withdrawn
 *
 * @category Class
 * @package  BookieGG\Models
 * @author   Michal Hojgr <michal.hojgr@gmail.com>
 * @license  MS Reference
 * @link     http://bookie.gg
 */
class UserTradeWithdrawItem extends Model
{
    /**
     * Trade this item belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user_trade()
    {
        return $this->belongsTo('BookieGG\Models\UserTrade');
    }

    /**
     * Bank row this item belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user_bank()
    {
        return $this->belongsTo('BookieGG\Models\UserBank');
    }
}

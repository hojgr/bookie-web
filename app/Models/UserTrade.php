<?php
/**
 * Model for User trades
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
 * Model for User trades
 *
 * @category Class
 * @package  BookieGG\Models
 * @author   Michal Hojgr <michal.hojgr@gmail.com>
 * @license  MS Reference
 * @link     http://bookie.gg
 */
class UserTrade extends Model
{
    /**
     * Items this trade has to deposit
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function user_trade_deposit_items()
    {
        return $this->hasMany('BookieGG\Models\UserTradeDepositItem');
    }

    /**
     * Items this trade has to withdraw
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function user_trade_withdraw_items()
    {
        return $this->hasMany('BookieGG\Models\UserTradeWithdrawItem');
    }

    public function bot()
    {
        return $this->belongsTo('BookieGG\Models\Bot');
    }

    public function getTradeURL()
    {
        return 'https://steamcommunity.com/tradeoffer/' . $this->trade_id . '/';
    }

    public function getCreatedAtTimestamp()
    {
        if ($this->trade_created_at instanceof \Datetime) {
            return $this->trade_created_at->getTimestamp();
        }

        return strtotime($this->trade_created_at);
    }
}

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
}

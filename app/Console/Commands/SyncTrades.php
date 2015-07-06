<?php
/**
 * Command for synchronizing all trades (redis->db)
 *
 * It is most likely to be called by cron every minute
 * or something cron-like every few seconds.
 *
 * PHP version 5.6
 *
 * @category Class
 * @package  BookieGG\Console\Commands
 * @author   Michal Hojgr <michal.hojgr@gmail.com>
 * @license  MS Reference
 * @link     http://bookie.gg
 */

namespace BookieGG\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use BookieGG\Services\RedisTrades;
use BookieGG\Services\TradeManager;
use BookieGG\Models\UserTrade;

/**
 * Command for syncing all trades
 *
 * PHP version 5.6
 *
 * @category Class
 * @package  BookieGG\Console\Commands
 * @author   Michal Hojgr <michal.hojgr@gmail.com>
 * @license  MS Reference
 * @link     http://bookie.gg
 */
class SyncTrades extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'sync:trades';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description
        = "Takes all trades from Redis and synchronizes them with database";

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @param RedisTrades  $redisTrades  Redis trades
     * @param TradeManager $tradeManager Trade manager
     *
     * @return mixed
     */
    public function fire(RedisTrades $redisTrades, TradeManager $tradeManager)
    {
        $this->info('Synchronizing trades');

        foreach ($redisTrades->eachTrade() as $trade) {
            if ($trade->isAccepted()) {
                $userTrade = UserTrade::where('redis_trade_id', '=', $trade->redisId)
                    ->first();

                if (!$userTrade) {
                    continue;
                }

                $affectedRows = UserTrade::where("status", "!=", TradeManager::STATUS_ACCEPTED)
                    ->where('id', '=', $userTrade->id)
                    ->update(['status' => TradeManager::STATUS_ACCEPTED]);

                if ($userTrade->type == "deposit") {
                    if ($affectedRows !== 1) {
                        $this->info("Trade unsuccessful due to $affectedRows not equal to 1");
                        continue;
                    } elseif ($affectedRows === 1) { // just to be sure future edits dont fuck it up
                        $tradeManager->assignItems($userTrade, $trade);
                    }
                } elseif ($userTrade->type == "withdraw") {
                    $tradeManager->removeItems($userTrade, $trade);
                }
                $redisTrades->delete($trade);
                $this->info(
                    sprintf(
                        "Trade #%d was accepted",
                        $trade->redisId
                    )
                );
            } if ($trade->isPending()) {
                $tradeManager->setStatus($trade, TradeManager::STATUS_ACTIVE);
                $this->info(
                    sprintf(
                        "Trade #%d is pending",
                        $trade->redisId
                    )
                );
            } elseif ($trade->isCancelled()) {
                $tradeManager->setStatus($trade, TradeManager::STATUS_CANCELLED);
                $redisTrades->delete($trade);
                $this->info(
                    sprintf(
                        "Trade #%d was cancelled",
                        $trade->redisId
                    )
                );
            }
        }
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [ ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [ ];
    }
}

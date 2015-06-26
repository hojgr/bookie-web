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
use BookieGG\Models\TradeStatus;
use BookieGG\Services\RedisTrades;

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
     * @param RedisTrades $redisTrades redis trades
     *
     * @return mixed
     */
    public function fire(RedisTrades $redisTrades)
    {
        $this->info('Synchronizing trades');

        foreach ($redisTrades->eachTrade() as $trade) {
            dd($trade);
            if ($trade->isAccepted()) {
                $this->info('Accepted');
            } if ($trade->isPending()) {
                $this->info('Pending');
            } elseif ($trade->isCancelled()) {
                $this->info('Cancelled');
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

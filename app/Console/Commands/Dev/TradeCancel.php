<?php

namespace BookieGG\Console\Commands\Dev;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Command for cancelling trades
 *
 * PHP version 5.6
 *
 * @category Class
 * @package  BookieGG\Console\Commands
 * @author   Michal Hojgr <michal.hojgr@gmail.com>
 * @license  MS Reference
 * @link     http://bookie.gg
 */
class TradeCancel extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'dev:trade:cancel';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description
        = "Cancels ALL pending/queue trades";

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
    public function fire()
    {
        $q = $this->ask('Do you really want to cancel ALL trades? (dangerous) (write "y")');
        if ($q == "y" || $q == "yes" || $q == "1") {
            \DB::table('user_trades')
                ->where('status', 'queue')
                ->orWhere('status', 'active')
                ->update(['status' => 'cancelled']);
            $this->info("Done");
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

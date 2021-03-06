<?php namespace BookieGG\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel {

    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        'BookieGG\Console\Commands\Inspire',
        'BookieGG\Console\Commands\SqliteCreate',

        'BookieGG\Console\Commands\User\UserList',
        'BookieGG\Console\Commands\User\UserActivate',
        'BookieGG\Console\Commands\User\UserDeactivate',

        'BookieGG\Console\Commands\Organization\OrganizationCreate',
        'BookieGG\Console\Commands\Organization\OrganizationList',
        'BookieGG\Console\Commands\Organization\OrganizationDelete',

        'BookieGG\Console\Commands\Team\TeamCreate',
        'BookieGG\Console\Commands\Team\TeamList',
        'BookieGG\Console\Commands\Team\TeamDelete',

        'BookieGG\Console\Commands\Match\MatchCreate',
        'BookieGG\Console\Commands\Match\MatchList',
        'BookieGG\Console\Commands\Match\MatchDelete',

        'BookieGG\Console\Commands\Item\ItemLookup',

        'BookieGG\Console\Commands\UserAdmin',

        'BookieGG\Console\Commands\SyncTrades',

        'BookieGG\Console\Commands\Dev\TradeCancel',
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('inspire')
                 ->hourly();
    }

}

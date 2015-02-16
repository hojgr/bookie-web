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
        'BookieGG\Console\Commands\UserList',
        'BookieGG\Console\Commands\UserActivate',
        'BookieGG\Console\Commands\UserDeactivate',
        'BookieGG\Console\Commands\SqliteCreate',

		'BookieGG\Console\Commands\HostCreate',
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

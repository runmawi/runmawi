<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
        Commands\LivestreamCron::class,
        Commands\VideostreamCron::class,
        Commands\Autodeploy::class,
        Commands\SubscriptionReminder::class,
        Commands\SubscriptionRenewal::class,
        Commands\SubscriptionExpiry::class,

    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('Autodeploy:cron')
        ->everyMinute();

        // $schedule->command('inspire')->hourly();
        $schedule->command('livestream:cron')
        ->everyMinute();

        $schedule->command('videostream:cron')
        ->everyMinute();

        $schedule->command('SubscriptionReminder:cron')
        ->everyMinute();

        $schedule->command('SubscriptionRenewal:cron')
        ->everyMinute();

        $schedule->command('SubscriptionExpiry:cron')
        ->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

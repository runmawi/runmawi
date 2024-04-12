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
        Commands\SubscriptionExpiredUsersCron::class,
        Commands\SubscriptionReminder::class,
        // Commands\SubscriptionRenewal::class,
        // Commands\GenerateSitemap::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('subscriptionexpiredusers:cron')->daily();

        $schedule->command('SubscriptionReminder:cron')->dailyAt('08:00');

        // $schedule->command('SubscriptionRenewal:cron')
        // ->dailyAt('13:00');

        // $schedule->command('sitemap:generate')->everyMinute();

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
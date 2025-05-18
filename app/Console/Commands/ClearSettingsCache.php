<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Facades\Settings;

class ClearSettingsCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'settings:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear the settings cache';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Settings::clearCache();
        $this->info('Settings cache cleared successfully!');
        return 0;
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\PpvPurchase;
use Carbon\Carbon;

class CleanupAbandonedPayments extends Command
{
    protected $signature = 'payments:cleanup-abandoned';
    protected $description = 'Clean up abandoned payment records with hold status older than 24 hours';

    public function handle()
    {
        $cutoffTime = Carbon::now()->subHours(24);
        
        $deletedCount = PpvPurchase::where('status', 'hold')
            ->where('created_at', '<', $cutoffTime)
            ->delete();
            
        $this->info("Cleaned up {$deletedCount} abandoned payment records.");
        
        return 0;
    }
} 
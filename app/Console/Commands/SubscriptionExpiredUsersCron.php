<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Subscription;
use App\User;
use Carbon\Carbon;

class SubscriptionExpiredUsersCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscriptionexpiredusers:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh the role for users whose subscriptions have expired';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $current_date_time = Carbon::now();

        $subscription_expired_users = App\User::whereDate('subscription_ends_at', '>' ,now())
                                      ->whereTime('subscription_ends_at', '<=', now()->startOfMinute())
                                      ->get();

        if(count($subscription_expired_users) > 0){

              foreach($subscription_expired_users as $subscription_expired_user ){

                User::where('id',$subscription_expired_user->id)->update([
                    'role'                  => 'registered',
                    'payment_status'        => 'Expiry',
                    'stripe_id'             =>  null,
                    'subscription_start'    =>  null,
                    'subscription_ends_at'  =>  null,
                    'payment_gateway'       =>  null,
                ]);

              }
        }
    }
}

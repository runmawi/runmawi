<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Subscription;
use App\User;

class SubscriptionExpiredRoleChangeCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'SubscriptionExpiredRoleChange:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Subscription Expired Role Change';

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
        $users_subscriptions = User::query()->where('role','subscriber')->where('subscription_ends_at', '<', Carbon::now()->format('Y-m-d h:i:s') )->get();

        foreach ($users_subscriptions as $key => $users_subscription) {

            Subscription::where('stripe_id', $users_subscription->stripe_id)->update(['stripe_status' => 'Expiry']);

            User::find( $users_subscription->id )->update([
                'role'                  => 'registered',
                'stripe_id'             =>  null,
                'subscription_start'    =>  null,
                'subscription_ends_at'  =>  null,
                'payment_type'          =>  null,
                'payment_gateway'       =>  null,
                'coupon_used'           =>  null ,
                'payment_status'        =>  'Expiry',
                'Subscription_trail_status'   =>  null ,
                'Subscription_trail_tilldate' =>  null ,

            ]);
        }

        \Log::channel('cron')->info("Subscription Expired Role Change Cron is working fine!");

    }
}

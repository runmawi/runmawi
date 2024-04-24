<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Razorpay\Api\Api;
use App\PaymentSetting;
use App\User;
use Carbon\Carbon;

class SubscriberAutoRenewalCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'SubscriberAutoRenewal:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Subscriber Auto Renewal';

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

        // Razorpay
        
        $Razorpay_PaymentSetting = PaymentSetting::where('payment_type','Razorpay')->first();

        try {
     
           if( $Razorpay_PaymentSetting != null && $Razorpay_PaymentSetting->live_mode == 0 ){
     
              $razorpaykeyId = $Razorpay_PaymentSetting->live_publishable_key;
              $razorpaykeysecret = $Razorpay_PaymentSetting->live_secret_key;
     
              $Razorpay_Subscriber_users = User::where('payment_gateway','Razorpay')->where('payment_status','active')->get();
     
                foreach ($Razorpay_Subscriber_users as $key => $Razorpay_Subscriber_user) {
    
                    $api = new Api($razorpaykeyId, $razorpaykeysecret);
                    $subscription = $api->subscription->fetch($Razorpay_Subscriber_user->stripe_id);
                    
                    $subscription_ends_at = Carbon::createFromTimestamp($subscription['current_end'])->toDateTimeString(); 
        
                    if( $Razorpay_Subscriber_user->subscription_ends_at < Carbon::now()->format('Y-m-d h:i:s')){
        
                        User::where('id',$Razorpay_Subscriber_user->id)->update(['subscription_ends_at' => $subscription_ends_at]);
        
                    }
                
                }
           }
     
        } catch (\Throwable $th) {
           //throw $th;
        }

        // Stripe 

        $stripe_Subscriber_users = User::where('payment_gateway','Stripe')->where('payment_status','active')->get();

        try {

            foreach ($stripe_Subscriber_users as $key => $stripe_Subscriber_user ) {

                $stripe = new \Stripe\StripeClient( env('STRIPE_SECRET') );
                $stripe_subscriptions = $stripe->subscriptions->retrieve($stripe_Subscriber_user->stripe_id, []);
    
                $subscription_ends_at = Carbon::createFromTimestamp($stripe_subscriptions['current_period_end'])->toDateTimeString(); 
    
                if( $stripe_Subscriber_user->subscription_ends_at < Carbon::now()->format('Y-m-d h:i:s')){
    
                    User::where('id',$stripe_Subscriber_user->id)->update(['subscription_ends_at' => $subscription_ends_at]);
    
                }
            }

        } catch (\Throwable $th) {
            //throw $th;
        }

        \Log::channel('cron')->info("Subscriber Auto Renewal Cron is working fine!");

    }
}

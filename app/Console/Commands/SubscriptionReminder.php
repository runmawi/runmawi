<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use URL;
use \App\User as User;
use \App\Subscription as Subscription;
use DB;
use App\Plan as Plan;
use Carbon\Carbon;
use Mail;
use Auth;
use Laravel\Cashier\Invoice;

class SubscriptionReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'renewalnotify:name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Renewal Notify ';

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
        // return 0;
        $users = User::select('subscriptions.ends_at as end_date','users.*','subscription_plans.plans_name as plans_name','subscription_plans.price as price')
        ->join('subscriptions', 'users.id', '=', 'subscriptions.user_id')
        ->join('subscription_plans', 'subscriptions.stripe_plan', '=', 'subscription_plans.plan_id')
        ->where('role','subscriber')->get();

            foreach($users as $key => $user){
                $end_to = date('Y-m-d', strtotime('-10 day', strtotime($user->end_date)));
                $end_date = date('Y-m-d',strtotime($user->end_date));
                $current_date = date('Y-m-d');

                if ($current_date <= $end_date){
                    Mail::send('emails.renewalnotify', array(
                            'name' => $plans->username,
                            'plan' => $plans->plans_name,
                            'price' => $plans->price,
                            'ends_at' => $to_date
                        ), function($message) use ($plans){
                        $message->to($plans->email, $plans->username)->subject('Subscription Renewal Notification');
                    });

                }else{

                }

            }
    }
}

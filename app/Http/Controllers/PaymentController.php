<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use \App\User as User;
use \Redirect as Redirect;
//use Request;
use URL;
use Auth;
use App\Setting as Setting;
use App\PpvPurchase as PpvPurchase;
use App\Subscription as Subscription;
use App\CouponPurchase as CouponPurchase;
use App\Episode as Episode;
use App\Plan as Plan;
use App\PaypalPlan as PaypalPlan;
use Hash;
use Illuminate\Support\Facades\Cache;
use Image;
use View;
use DB;
use Carbon\Carbon;
use Cartalyst\Stripe\Stripe;
use Mail;
use App\Video;
use App\VideoCommission;
use App\EmailTemplate;
use App\PaymentSetting;
use App\SubscriptionPlan;
use Session;
use App\LivePurchase;
use App\Series;
use App\SeriesSeason;
use App\Devices;
use App\HomeSetting;
use App\ModeratorsUser;
use App\LiveStream;
use Theme;
use Laravel\Cashier\Cashier;
use App\SiteTheme;
use App\Channel;


class PaymentController extends Controller
{
  public function index()
  {
    return View::make('stripe');

  }


  public function store(Request $request)
  {
              $current_date = date('m/d/Y h:i:s a', time());    
                $setting = Setting::first();   
                $ppv_hours = $setting->ppv_hours;
                $user_id = Auth::user()->id;
                $video_id = $request->get('video_id');
                $date = Carbon::parse($current_date)->addDays(1);
                // $stripe = new Stripe();
                $price = $request->get('amount');

              $stripe = new \Stripe\StripeClient(
                  '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'
                );
      
            $stripe->charges->create([
              'amount' =>  $request->get('amount').'00',
              'currency' => 'USD',
              'source' => $request->get('tokenId'),
              'description' => 'My First Test Charge (created for API docs)',
            ]);
            $purchase = new PpvPurchase;
            $purchase->user_id = $user_id;
            $purchase->video_id = $video_id;
            $purchase->to_time = $to_time;
            $purchase->save();
            //  DB::table('ppv_purchases')->insert([
            //         ['user_id' => $user_id, 'video_id' => $video_id, 'to_time' => $date]
            //     ]);
             return back();
  }   
public function RentPaypal(Request $request)
  {
    
                $current_date = date('m/d/Y h:i:s a', time());    
                $setting = Setting::first();   
                $ppv_hours = $setting->ppv_hours;
                $user_id = Auth::user()->id;
                $video_id = $request->get('video_id');
                $date = Carbon::parse($current_date)->addDays(1);
              $purchase = new PpvPurchase;
              $purchase->user_id = $user_id;
              $purchase->video_id = $video_id;
              $purchase->to_time = $to_time;
              $purchase->save();
                // DB::table('ppv_purchases')->insert([
                //     ['user_id' => $user_id, 'video_id' => $video_id, 'to_time' => $date]
                // ]);
             return back();
  }     

    public function MyRefferal()
      {
            $user_id = Auth::user()->id;
            $myrefferals = User::find($user_id)->referrals;
            $data = array(
              'myreferral' => $myrefferals  
            );
            return view('my-refferals', $data);
      }
    
    public function BecomePaypal(Request $request){
        
            $subId = $request->get('subId'); 
            $user_id = Auth::user()->id;
            $user = User::find($user_id);
            $user->role = 'subscriber';
            $user->active = 1;
            $user->paypal_end_at = $paypal_end_at;
            $user->paypal_id = $subId;
            $user->save();
            return redirect('/myprofile');
    }

  public function StoreLive(Request $request)
  {
    $daten = date('m-d-Y h:i:s ', time());    
    $setting = Setting::first();   
    $ppv_hours = $setting->ppv_hours;
    $d = new \DateTime('now');
    $d->setTimezone(new \DateTimeZone('Asia/Kolkata'));
    $now = $d->format('Y-m-d h:i:s a');
    $time = date('h:i:s', strtotime($now));
    $to_time = date('Y-m-d H:i:s',strtotime('+'.$ppv_hours.' hour',strtotime($now))); 
    $user_id = Auth::user()->id;
    $video_id = $request->get('video_id');
    $date = date('YYYY-MM-DD');

    $video = LiveStream::where('id','=',$video_id)->where('uploaded_by','CPP')->first();

    $channelvideo = LiveStream::where('id','=',$video_id)->where('uploaded_by','Channel')->first();
  
    if(!empty($video)){
      $moderators_id = $video->user_id;
     }
  
    // $video = LiveStream::where('id','=',$video_id)->first();
    if(!empty($video)){
      $moderators_id = $video->user_id;
     }
     if(!empty($moderators_id)){
      $moderator = ModeratorsUser::where('id','=',$moderators_id)->first();  
      $total_amount = $video->ppv_price;
      $title =  $video->title;
      // $commssion = VideoCommission::first();
      $commission = VideoCommission::where('type', 'CPP')->first();
      $percentage = $commission->percentage; 
      $ppv_price = $video->ppv_price;
      // $admin_commssion = ($percentage/100) * $ppv_price ;
      $moderator_commssion = $ppv_price - $percentage;
      $admin_commssion =  $ppv_price - $moderator_commssion;
      $moderator_id = $moderators_id;
      $channel_id = null ;

    }elseif(!empty($channelvideo)){
      if(!empty($channelvideo)){
        $channelvideo_id = $channelvideo->user_id;
       }
       $Channel = Channel::where('id','=',$channelvideo_id)->first();  
       $total_amount = $channelvideo->ppv_price;
       $title =  $channelvideo->title;
       $commssion = VideoCommission::where('type','Channel')->first();
       $percentage = $commssion->percentage; 
       $ppv_price = $channelvideo->ppv_price;
       // $admin_commssion = ($percentage/100) * $ppv_price ;
       $moderator_commssion = $ppv_price - $percentage;
       $admin_commssion =  $ppv_price - $moderator_commssion;
       $channel_id = $channelvideo_id;
       $moderator_id = null;
  
    }
    else{
      $total_amount = $video->ppv_price;
      $title =  $video->title;
      $commssion = VideoCommission::first();
      $percentage = null; 
      $ppv_price = $video->ppv_price;
      $admin_commssion =  null;
      $moderator_commssion = null;
      $moderator_id = null;
      $channel_id = null ;
    }
    
    // if(!empty($moderators_id)){
    //   $moderator = ModeratorsUser::where('id','=',$moderators_id)->first();  
    //   $total_amount = $video->ppv_price;
    //   $title =  $video->title;
    //   $commssion = VideoCommission::first();
    //   $percentage = $commssion->percentage; 
    //   $ppv_price = $video->ppv_price;
    //   $admin_commssion = ($percentage/100) * $ppv_price ;
    //   $moderator_commssion = $ppv_price - $percentage;
    //   $moderator_id = $moderators_id;
    // }else{
    //   $total_amount = $video->ppv_price;
    //   $title =  $video->title;
    //   $commssion = VideoCommission::first();
    //   $percentage = null; 
    //   $ppv_price = $video->ppv_price;
    //   $admin_commssion =  null;
    //   $moderator_commssion = null;
    //   $moderator_id = null;

    // }
    $payment_settings = PaymentSetting::first();  
    $mode = $payment_settings->live_mode ;
      if($mode == 0){
          $secret_key = $payment_settings->test_secret_key ;
          $publishable_key = $payment_settings->test_publishable_key ;
      }elseif($mode == 1){
          $secret_key = $payment_settings->live_secret_key ;
          $publishable_key = $payment_settings->live_publishable_key ;
      }else{
          $secret_key= null;
          $publishable_key= null;
      } 

   
      $stripe = Stripe::make($secret_key, '2020-03-02');
      $charge = $stripe->charges()->create([
        'source' => $request->get('tokenId'),
        'currency' => 'USD',
        'amount' => $request->get('amount')
      ]);

    $purchase = new PpvPurchase;
    $purchase->user_id = $user_id;
    $purchase->live_id = $video_id;
    $purchase->to_time = $to_time;
    $purchase->expired_date = $to_time;
    $purchase->total_amount = $total_amount;
    $purchase->admin_commssion = $admin_commssion;
    $purchase->moderator_commssion = $moderator_commssion;
    $purchase->status = 'active';
    $purchase->to_time = $to_time;
    $purchase->moderator_id = $moderator_id;
    $purchase->channel_id = $channel_id;
    $purchase->save();

    $livepurchase = new LivePurchase;
    $livepurchase->user_id = $user_id;
    $livepurchase->video_id = $video_id;
    $livepurchase->to_time = $to_time;
    $livepurchase->expired_date = $to_time;
    $livepurchase->amount = $request->get('amount');
    $livepurchase->status = 1;
    $livepurchase->save();
    
    // DB::table('live_purchases')->insert([
    //   ['user_id' => $user_id, 'video_id' => $video_id, 'expired_date' => $to_time, 'to_time' => $to_time]
    // ]);


    return 1;
  }

  public function purchaseSeries(Request $request)
  {
    // dd($request->all());
    $data = $request->all();
    $series_id = $data['series_id'];
    $setting = Setting::first();  
    $ppv_hours = $setting->ppv_hours;
    // $to_time =  Carbon::now()->addHour($ppv_hours);
    $d = new \DateTime('now');
    $d->setTimezone(new \DateTimeZone('Asia/Kolkata'));
    $now = $d->format('Y-m-d h:i:s a');
    // dd($now);
    $time = date('h:i:s', strtotime($now));
    $to_time = date('Y-m-d h:i:s a',strtotime('+'.$ppv_hours.' hour',strtotime($now)));                        
    $user_id = Auth::user()->id;
    $username = Auth::user()->username;
    $email = Auth::user()->email;

    // $series_id = $request->get('series_id');
    // print_r($series_id);exit();
    $series = Series::where('id','=',$series_id)->first();  
    $total_amount = $setting->ppv_price;
    $title =  $series->title;
    $commssion = VideoCommission::first();
    $percentage = $commssion->percentage; 
    $ppv_price = $setting->ppv_price;
    $admin_commssion = ($percentage/100) * $ppv_price ;
    $moderator_commssion = $ppv_price - $percentage;
    $payment_settings = PaymentSetting::first();  
    $mode = $payment_settings->live_mode ;
      if($mode == 0){
          $secret_key = $payment_settings->test_secret_key ;
          $publishable_key = $payment_settings->test_publishable_key ;
      }elseif($mode == 1){
          $secret_key = $payment_settings->live_secret_key ;
          $publishable_key = $payment_settings->live_publishable_key ;
      }else{
          $secret_key= null;
          $publishable_key= null;
      } 
    $stripe = Stripe::make($secret_key, '2020-03-02');
    $charge = $stripe->charges()->create([
      'source' => $request->get('tokenId'),
      'currency' => 'USD',
      'amount' => $request->get('amount')
    ]);
    $purchase = new PpvPurchase;
    $purchase->user_id = $user_id;
    $purchase->series_id = $series_id;
    $purchase->total_amount = $total_amount;
    $purchase->admin_commssion = $admin_commssion;
    $purchase->moderator_commssion = $moderator_commssion;
    $purchase->status = 'active';
    $purchase->to_time = $to_time;

    $purchase->save();

    $template = EmailTemplate::where('id','=',11)->first();
    $heading =$template->heading; 

    // Mail::send('emails.payperview_rent', array(
    //     /* 'activation_code', $user->activation_code,*/
    //     'name'=> $username, 
    //     'email' => $email, 
    //     'title' => $title, 
    //     ), function($message) use ($request,$username,$heading,$email) {
    //     $message->from(AdminMail(),'Flicknexs');
    //     $message->to($email, $username)->subject($heading.$username);
    //     });

    return 1;
  }

  public function purchaseEpisode(Request $request)
  {
    // dd($request->all());
    $data = $request->all();
    $episode_id = $data['episode_id'];
    $season_id = $data['season_id'];
    // $series_id = $data['series_id'];

    $setting = Setting::first();  
    $ppv_hours = $setting->ppv_hours;
    // $to_time =  Carbon::now()->addHour($ppv_hours);
    $d = new \DateTime('now');
    $d->setTimezone(new \DateTimeZone('Asia/Kolkata'));
    $now = $d->format('Y-m-d h:i:s a');
    // dd($now);
    $time = date('h:i:s', strtotime($now));
    $to_time = date('Y-m-d h:i:s a',strtotime('+'.$ppv_hours.' hour',strtotime($now)));                        
    $user_id = Auth::user()->id;
    $username = Auth::user()->username;
    $email = Auth::user()->email;

    // $episode_id = $request->get('episode_id');
    // print_r($episode_id);exit();
    $episode = Episode::where('id','=',$episode_id)->first();  
    $total_amount = $episode->ppv_price;
    $title =  $episode->title;
    $commssion = VideoCommission::first();
    $percentage = $commssion->percentage; 
    $ppv_price = $episode->ppv_price;
    $admin_commssion = ($percentage/100) * $ppv_price ;
    $moderator_commssion = $ppv_price - $percentage;
    $payment_settings = PaymentSetting::first();  
    $mode = $payment_settings->live_mode ;
      if($mode == 0){
          $secret_key = $payment_settings->test_secret_key ;
          $publishable_key = $payment_settings->test_publishable_key ;
      }elseif($mode == 1){
          $secret_key = $payment_settings->live_secret_key ;
          $publishable_key = $payment_settings->live_publishable_key ;
      }else{
          $secret_key= null;
          $publishable_key= null;
      } 
    $stripe = Stripe::make($secret_key, '2020-03-02');
    $charge = $stripe->charges()->create([
      'source' => $request->get('tokenId'),
      'currency' => 'USD',
      'amount' => $request->get('amount')
    ]);
    $purchase = new PpvPurchase;
    $purchase->user_id = $user_id;
    $purchase->episode_id = $episode_id;
    $purchase->season_id = $season_id;
    $purchase->series_id = $episode->series_id;
    $purchase->total_amount = $total_amount;
    $purchase->admin_commssion = $admin_commssion;
    $purchase->moderator_commssion = $moderator_commssion;
    $purchase->status = 'active';
    $purchase->to_time = $to_time;

    $purchase->save();

    $template = EmailTemplate::where('id','=',11)->first();
    $heading =$template->heading; 

    // Mail::send('emails.payperview_rent', array(
    //     /* 'activation_code', $user->activation_code,*/
    //     'name'=> $username, 
    //     'email' => $email, 
    //     'title' => $title, 
    //     ), function($message) use ($request,$username,$heading,$email) {
    //     $message->from(AdminMail(),'Flicknexs');
    //     $message->to($email, $username)->subject($heading.$username);
    //     });

    return 1;
  }


  public function purchaseVideo(Request $request)
  {
    // dd($request->all());
    $data = $request->all();
    $video_id = $data['video_id'];
    $setting = Setting::first();  
    $ppv_hours = $setting->ppv_hours;
    // $to_time =  Carbon::now()->addHour($ppv_hours);
    $d = new \DateTime('now');
    $d->setTimezone(new \DateTimeZone('Asia/Kolkata'));
    $now = $d->format('Y-m-d h:i:s a');
    // dd($now);
    $time = date('h:i:s', strtotime($now));
    $to_time = date('Y-m-d h:i:s a',strtotime('+'.$ppv_hours.' hour',strtotime($now)));                        
    $user_id = Auth::user()->id;
    $username = Auth::user()->username;
    $email = Auth::user()->email;

    // $video_id = $request->get('video_id');
    // print_r($video_id);exit();
    $video = Video::where('id','=',$video_id)->where('uploaded_by','CPP')->first();

    $channelvideo = Video::where('id','=',$video_id)->where('uploaded_by','Channel')->first();

    if(!empty($video)){
      $moderators_id = $video->user_id;
     }

    if(!empty($moderators_id)){
      $moderator = ModeratorsUser::where('id','=',$moderators_id)->first();  
      $total_amount = $video->ppv_price;
      $title =  $video->title;
      // $commssion = VideoCommission::first();
      $commission = VideoCommission::where('type', 'CPP')->first();
      $percentage = $commssion->percentage; 
      $ppv_price = $video->ppv_price;
      // $admin_commssion = ($percentage/100) * $ppv_price ;
      $moderator_commssion = $ppv_price - $percentage;
      $admin_commssion =  $ppv_price - $moderator_commssion;
      $moderator_id = $moderators_id;
    }elseif(!empty($channelvideo)){
      if(!empty($channelvideo)){
        $channelvideo_id = $video->user_id;
       }
       $Channel = Channel::where('id','=',$channelvideo_id)->first();  
       $total_amount = $video->ppv_price;
       $title =  $video->title;
       $commssion = VideoCommission::where('type','Channel')->first();;
       $percentage = $commssion->percentage; 
       $ppv_price = $video->ppv_price;
       // $admin_commssion = ($percentage/100) * $ppv_price ;
       $moderator_commssion = $ppv_price - $percentage;
       $admin_commssion =  $ppv_price - $moderator_commssion;
       $channel_id = $channelvideo_id;

    }
    else{
      $total_amount = $video->ppv_price;
      $title =  $video->title;
      $commssion = VideoCommission::first();
      $percentage = null; 
      $ppv_price = $video->ppv_price;
      $admin_commssion =  null;
      $moderator_commssion = null;
      $moderator_id = null;

    }
    
    // $video = Video::where('id','=',103)->first();  

    $payment_settings = PaymentSetting::first();  
    $mode = $payment_settings->live_mode ;
      if($mode == 0){
          $secret_key = $payment_settings->test_secret_key ;
          $publishable_key = $payment_settings->test_publishable_key ;
      }elseif($mode == 1){
          $secret_key = $payment_settings->live_secret_key ;
          $publishable_key = $payment_settings->live_publishable_key ;
      }else{
          $secret_key= null;
          $publishable_key= null;
      } 
    $stripe = Stripe::make($secret_key, '2020-03-02');
    $charge = $stripe->charges()->create([
      'source' => $request->get('tokenId'),
      'currency' => 'USD',
      'amount' => $request->get('amount')
    ]);
    $purchase = new PpvPurchase;
    $purchase->user_id = $user_id;
    $purchase->video_id = $video_id;
    $purchase->total_amount = $total_amount;
    $purchase->admin_commssion = $admin_commssion;
    $purchase->moderator_commssion = $moderator_commssion;
    $purchase->status = 'active';
    $purchase->to_time = $to_time;
    $purchase->moderator_id = $moderator_id;

    $purchase->save();
    // DB::table('ppv_purchases')->insert([
    //   ['user_id' => $user_id, 'video_id' => $video_id,  'total_amount' => $ppv_price,'admin_commssion' => $admin_commssion, 
    // 'moderator_commssion' => $moderator_commssion, 'to_time' => $to_time, 'status' => 'active']
    // ]);

    $template = EmailTemplate::where('id','=',11)->first();
    $heading =$template->heading; 
    //   echo "<pre>";
    // print_r($heading);
    // exit();

    // Mail::send('emails.payperview_rent', array(
    //     /* 'activation_code', $user->activation_code,*/
    //     'name'=> $username, 
    //     'email' => $email, 
    //     'title' => $title, 
    //     ), function($message) use ($request,$username,$heading,$email) {
    //     $message->from(AdminMail(),'Flicknexs');
    //     $message->to($email, $username)->subject($heading.$username);
    //     });

    return 1;
  }

  public function upgrading(Request $request) {

        $uid = Auth::user()->id;

        $user = User::where('id',$uid)->first();
        if ($user->stripe_id == NULL)
        {
          $stripeCustomer = $user->createAsStripeCustomer();
        }

        return view('register.upgrade', [
          'intent' => $user->createSetupIntent()
          ,compact('register')
        ]);
  }  
    
  public function UpdateCard()
    {
      $user = User::where('id',1)->first();
        if ($user->stripe_id == NULL)
            {
              $stripeCustomer = $user->createAsStripeCustomer();

         }
        return view('update', [
              'intent' => $user->createSetupIntent()
              ,compact('register')
        ]);
    }

    public function CancelSubscription()
        {
       
          $Razorpay = User::where('users.id',Auth::user()->id)
          ->Join("subscriptions", "subscriptions.user_id", "=", "users.id")
          ->whereColumn('users.stripe_id', '=', 'subscriptions.stripe_id')
          ->first();

          if($Razorpay != null && $Razorpay->PaymentGateway  ==  "Razorpay"){
            return redirect::to('RazorpayCancelSubscriptions');
          }
          else{
                      // Subscription Cancel
              try {
                    $user = Auth::user();
                    $stripe_plan = Subscription::where('user_id',$user->id)->latest()->pluck('stripe_id')->first();
                    $stripe = new \Stripe\StripeClient( env('STRIPE_SECRET') );
                    $stripe->subscriptions->cancel( $stripe_plan,[] );

                    $user = User::find(Auth::user()->id);
                    $user->payment_status = 'Cancel';
                    $user->save();
                    
              } catch (\Throwable $th) {

                    return redirect::to('myprofile')->with(array(
                      'message' => 'There was a failure to terminate the subscription !' ."\r\n". $th->getMessage() ,
                      'note_type' => 'error'
                    ));
              }
                    // Email 

            $plan_name =  CurrentSubPlanName(Auth::user()->id);
            $start_date =  SubStartDate(Auth::user()->id);
            $ends_at =  SubEndDate(Auth::user()->id);
            $template = EmailTemplate::where('id','=', 27)->first(); 
            $heading = $template->heading;

            try {
                \Mail::send('emails.cancelsubscription', array(
                  'name' => $user->username,
                  'plan_name' => $plan_name,
                  'start_date' => $start_date,
                  'ends_at' => $ends_at,
              
              ), function($message) use ($user,$heading,$plan_name){
                  $message->from(AdminMail(),GetWebsiteName());
                  $message->to($user->email, $user->username)->subject($plan_name.' '.$heading);
              });
             
                $email_log      = 'Mail Sent Successfully from cancel subscription';
                $email_template = "27";
                $user_id = Auth::user()->id;
    
                Email_sent_log($user_id,$email_log,$email_template);

            }
             catch (\Throwable $th) {

                $email_log      = $th->getMessage();
                $email_template = "27";
                $user_id = Auth::user()->id;

                Email_notsent_log($user_id,$email_log,$email_template);
            }
            
          

            Subscription::where('stripe_id',$stripe_plan)->update([
              'stripe_status' =>  'Cancel',
              'updated_at'    =>  Carbon::now()->toDateTimeString(),
            ]);

            return redirect::to('myprofile')->with(array(
                'message' => 'Your subscription was successfully terminated!',
                'note_type' => 'success'
            ));
          }
       }

        public function RenewSubscription()
        {
            $user = Auth::user();
            $stripe_plan = SubscriptionPlan();
            $user->subscription($stripe_plan)->resume();
            $planvalue = $user->subscriptions;
            $plan = $planvalue[0]->stripe_plan;
            $plandetail = SubscriptionPlan::where('plan_id',$plan)->first();
          
            \Mail::send('emails.renewsubscriptionemail', array(
                'name' => $user->username,
                'plan' => ucfirst($plandetail->plans_name),
               // 'price' => $plandetail->price,
            ), function($message) use ($user){
                $message->from(AdminMail(),GetWebsiteName());
                $message->to($user->email, $user->username)->subject('Subscription Renewal');
            });
            
            return redirect::to('myprofile');

        }
    
     public function UpgradeStripe(Request $request){

        $Theme = HomeSetting::pluck('theme_choosen')->first();
        Theme::uses(  $Theme );

         $plan_id = $request->get('modal_plan_name');

         $payment_method = $request->payment_method;

      if($request->payment_method == "Stripe"){
         $plan_details = SubscriptionPlan::where('plans_name', '=', $request->modal_plan_name)
                ->where('type', '=', $request->payment_method)
                ->first();

        $payment_type = $plan_details->payment_type;
        $user = Auth::user();

        if ( $plan_details->payment_type == "recurring") {

              if ($user->stripe_id == NULL)
                   {
                       $stripeCustomer = $user->createAsStripeCustomer();
                   }
               $response = array(
                "plans_details" => $plan_details,
                "plan_id" => $plan_id,
                "payment_type" => $plan_details->payment_type
              );

             return Theme::view('register.upgrade.stripe',[
                        "intent" => $user->createSetupIntent(),
                        "plans_details" => $plan_details,
                        "plan_id" => $plan_id,
                        "payment_type" => $plan_details->payment_type
            ]); 
           } else {
           if ($user->stripe_id == NULL)
           {
               $stripeCustomer = $user->createAsStripeCustomer();
           }
           $response = array(
               "plans_details" => $plan_details,
               "plan_id" => $plan_id,
               "payment_type" => $plan_details->payment_type
           );
           return Theme::view('register.upgrade.stripe',[
                              "intent" => $user->createSetupIntent(),
                              "plans_details" => $plan_details,
                              "plan_id" => $plan_id,
                              "payment_type" => $plan_details->payment_type
            ]);
         }      
      }
      elseif($request->payment_method == "Razorpay"){

        $plan_details = SubscriptionPlan::where('plans_name', '=', $request->modal_plan_name)
        ->where('type', '=', $request->payment_method)
        ->first();

        $PlanId   = $plan_details['plan_id']; 
        return Redirect::route('RazorpaySubscriptionUpdate',$PlanId);
      }       
     }  
    
    public function UpgradePaypalPage(Request $request){
         $paypal_details = $request->all();
         $plan_id = $request->get('name');
         $plan_details = SubscriptionPlan::where("plan_id","=",$plan_id)->first();
         $response = array(
             "plans_details" => $plan_details
         );
         return view('register.upgrade.paypal',$response);
     }
    
        
    public function upgradePaypal(Request $request){
        
            $subscription_id = Auth::user()->paypal_id;
            $user = Auth::user();
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://api.paypal.com/v1/billing/subscriptions/'.$subscription_id.'/cancel');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            $headers = array();
            $headers[] = 'Content-Type: application/json';
            $headers[] = GetAccessToken();
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result = curl_exec($ch);
            if (curl_errno($ch)) {
                   return redirect('/upgrade-subscription')->with( ['data' => "Error While cancel and Update subscription"] );
            }
                $email = Auth::user()->email;
                $user_email = User::where('email','=',$email)->count();
                $user_first = User::where('email','=',$email)->first();
                $id = $user_first->id; 
            if ( $user_email > 0 ) {
                   // $subIds = $request->get('subId');           
                    $subId = $request->subId;        
                    $new_user = User::find($id);
                    $new_user->role = 'subscriber';
                    $new_user->paypal_id = $subId;
                    $new_user->payment_type ='paypal';
                    $new_user->save();
                    $response = array(
                          'status' => 'success'
                    );
                } else {
                     $response = array(
                          'status' => 'failed'
                     );
                  }
             return response()->json($response);
        
    }
    
    
      public function ViewStripe(Request $request){
           $user_id = Auth::user()->id;
           
           $user_details = subscription::where("user_id","=",$user_id)->orderby("created_at","desc")->first();
          //  dd($user_details);
            $stripe_id =  $user_details->stripe_id;
            $stripe_status =  $user_details->stripe_status;
            $stripe_Plan =  $user_details->stripe_plan;
            $stripe = new \Stripe\StripeClient('sk_test_FIoIgIO9hnpVUiWCVj5ZZ96o005Yf8ncUt');
            $stripe_subscription = $stripe->subscriptions->retrieve(
                  $stripe_id,
                  []
                );
            
            $stripe_details = array(
                        'stripe_details' => $stirpe_subscription,
                        //'stripe_status' => $user_details->stripe_status,
                        'stripe_Plan' => $stripe_Plan,
                        'stripe_status' => $stripe_status
            );
            
           return View::make('stripe_billing',$stripe_details);
    }
    
    
      public function BecomeSubscriber()
        {

        $signup_checkout = SiteTheme::pluck('signup_theme')->first();


          if(!Auth::guest()){

            $Theme = HomeSetting::pluck('theme_choosen')->first();
            Theme::uses(  $Theme );

            $uid = Auth::user()->id;
            $user = User::where('id',$uid)->first();
            $plans = SubscriptionPlan::get();
            $plans_data = $plans->groupBy('plans_name');
            // dd($plans_data);
            Session::put('plans_data ', $plans_data );
            // if(!empty($plans->devices)){
              $devices = Devices::all();
            //   $permission = $plans->devices;
            //   $user_devices = explode(",",$permission);
            //   foreach($devices as $key => $value){
            //       if(in_array($value->id, $user_devices)){
            //           $devices_name[] = $value->devices_name;
            //       }
            //   }
            //  $plan_devices = implode(",",$devices_name);
            //  if(!empty($plan_devices)){
            //  $devices_name = $plan_devices;
            //  }else{
            //  $devices_name = "";
            //  }
            //  }

            if ($user->stripe_id == NULL)
            {
              $stripeCustomer = $user->createAsStripeCustomer();
            }
           /*return view('register.upgrade');*/


           if($signup_checkout == 1){

            $intent_stripe = User::where("id","=",Auth::user()->id)->first();
            $intent_key =  $intent_stripe->createSetupIntent()->client_secret ;
            session()->put('intent_stripe_key',$intent_key);

            return Theme::view('register.upgrade_payment', compact(['plans_data']));

          }else{
                return Theme::view('register.upgrade', [
                  'intent' => $user->createSetupIntent()
                /* ,compact('register')*/
                , compact('plans_data')
                ,'plans_data' => $plans_data
                ,'devices' => $devices

                ]);
          }

          }else{
            return Redirect::route('login');
          }

        }
         public function TransactionDetails(){  

          $Theme = HomeSetting::pluck('theme_choosen')->first();
          Theme::uses(  $Theme );

           if(!Auth::guest()){

            $user_id = Auth::user()->id;
            $subscriptions = Subscription::where('user_id',$user_id)->get(); 
            // $subscriptions = Subscription::where('user_id',$user_id)->get(); 
            $ppvcharse = PpvPurchase::where('user_id',$user_id)->get(); 
            $livepurchase = LivePurchase::where('user_id',$user_id)->get(); 

              if(!empty($subscriptions)){ 
                $subscriptionspurchase = $subscriptions; 
              }
              else{ 
                $subscriptionspurchase =[];
              }

              if(!empty($ppvcharse)){ 
                $ppvcharses = $ppvcharse; 
              }
              else{ 
                  $ppvcharses =[]; 
              }

              if(!empty($livepurchase)){
                $livepurchases = $livepurchase;
              }
              else{ 
                  $livepurchases =[]; 
              }

            return Theme::view('transactiondetails',
                                [ 'subscriptions'=>$subscriptions,
                                  'ppvcharse'=>$ppvcharses,
                                  'livepurchase'=>$livepurchases
                                ]);
          }
          else{
            return Theme::view('auth.login');
          }
    }

         public function saveSubscription(Request $request) {
        
                /* $user_email = Auth::user()->email;
                 $user = User::where('email',$user_email)->first();
                 $stripe_plan = SubscriptionPlan();
                 $paymentMethod = $request->get('py_id');
                 $plan = $request->get('plan');
                 $SubscribeDate = Date('d-m-Y');
                 $apply_coupon = $request->coupon_code;
                 $plandetail = Plan::where('plan_id',$plan)->first();
                 $paymentMethods = $user->paymentMethods();
                 if (!empty($apply_coupon)) {
                    $user->newSubscription($stripe_plan, $plan)->withCoupon($apply_coupon)->create($paymentMethod);
                 } else {
                     $user->newSubscription($stripe_plan, $plan)->create($paymentMethod);
                 }
                 $user->subscription_start = $SubscribeDate;
                 $user->role = 'subscriber';
                 $user->save();
                $response = array(
                    'status' => 'success'
                );
              return response()->json($response)*/
              $user_email = $request->session()->get('register.email');
              // $user = User::where('email',$user_email)->first();
              //  $user_email = Auth::user()->email;
                    $user_id = Auth::user()->user_id;
                    $user = User::where('email',$user_email)->first();
                    $paymentMethod = $request->get('py_id');
                    $plan = $request->get('plan');
                    // print_r($plan);exit();
                    $coupon_code = $request->coupon_code;
                    $payment_type = $request->payment_type;
                    $paymentMethods = $user->paymentMethods();
                    $apply_coupon = NewSubscriptionCouponCode();
                    $stripe_plan = SubscriptionPlan();
                    $plandetail = SubscriptionPlan::where('plan_id',$plan)->first();
                    $plan_name = ucfirst($plandetail->plans_name);
                    $template = EmailTemplate::where('id','=', 24)->first(); 
                    $heading = $template->heading; 
                    $current_date = date('Y-m-d h:i:s');    
                    $next_date = $plandetail->days;
                    $date = Carbon::parse($current_date)->addDays($next_date);


                    $ip = getenv('HTTP_CLIENT_IP');    
                $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
                $userIp = $geoip->getip();    
                $countryName = $geoip->getCountry();
                $regionName = $geoip->getregion();
                $cityName = $geoip->getcity();

                    
                    // Name Subscription Activated!
                     
                    if ( NewSubscriptionCoupon() == 1 || ExistingSubscription($user_id) == 0  ) {
                      try {
                           $user->newSubscription($stripe_plan, $plan)->withCoupon($apply_coupon)->create($paymentMethod);
                           $subscription = Subscription::where('user_id',$user->id)->first();
                           $subscription->price = $plandetail->price;
                           $subscription->name = $user->username;
                           $subscription->days = $plandetail->days;
                           $subscription->regionname = $regionName;
                           $subscription->countryname = $countryName;
                           $subscription->cityname = $cityName;
                           $subscription->ends_at = $date;
                           $subscription->save();
                          } catch (IncompletePayment $exception) {
                              return redirect()->route(
                                  'cashier.payment',
                                  [$exception->payment->id, 'redirect' => route('home')]
                              );
                          }
                      \Mail::send('emails.pruchase_subscription', array(
                          'name' => $user->username,
                          'paymentMethod' => $paymentMethod,
                          'plan' => ucfirst($plandetail->plans_name),
                          'price' => $plandetail->price,
                          'billing_interval' => $plandetail->billing_interval,
                          /*'next_billing' => $nextPaymentAttemptDate,*/
                      ), function($message) use ($request,$user,$plan_name,$heading){
                          $message->from(AdminMail(),GetWebsiteName());
                          $message->to($user->email, $user->username)->subject( $plan_name .' '. $heading);
                      });
                          $user->role = 'subscriber';
                          $user->card_type = 'stripe';
                          $user->active = 1;
                          $user->payment_type = $payment_type;
                          $user->save();
                          $subscription = Subscription::where('user_id',$user->id)->first();
                          $subscription->price = $plandetail->price;
                          $subscription->name = $user->username;
                           $subscription->days = $plandetail->days;
                           $subscription->regionname = $regionName;
                           $subscription->countryname = $countryName;
                           $subscription->cityname = $cityName;
                           $subscription->ends_at = $date;
                          $subscription->save();

              } else {

                  try {
                      
                          if (!empty($coupon_code)){
                                 $user->newSubscription($stripe_plan, $plan)->withCoupon($coupon_code)->create($paymentMethod);
                                 \Mail::send('emails.pruchase_subscription', array(
                                  'name' => $user->username,
                                  'paymentMethod' => $paymentMethod,
                                  'plan' => ucfirst($plandetail->plans_name),
                                  'price' => $plandetail->price,
                                  'billing_interval' => $plandetail->billing_interval,
                                  /*'next_billing' => $nextPaymentAttemptDate,*/
                              ), function($message) use ($request,$user,$plan_name,$heading){
                                  $message->from(AdminMail(),GetWebsiteName());
                                  $message->to($user->email, $user->username)->subject( $plan_name .' '. $heading);
                              });
                                          $user->role = 'subscriber';
                                          $user->payment_type = $payment_type;
                                          $user->card_type = 'stripe';
                                          $user->active = 1;
                                          $user->save();
                                          $subscription = Subscription::where('user_id',$user->id)->first();
                                          $subscription->price = $plandetail->price;
                                          $subscription->name = $user->username;
                                          $subscription->days = $plandetail->days;
                                          $subscription->ends_at = $date;
                                          $subscription->regionname = $regionName;
                                          $subscription->countryname = $countryName;
                                          $subscription->cityname = $cityName;
                                          $subscription->save();
                                          $response = array(
                                            'status' => 'success'
                                          );
                                          return response()->json($response);

                          }else {
                                $user->newSubscription($stripe_plan, $plan)->create($paymentMethod);
                                \Mail::send('emails.pruchase_subscription', array(
                                  'name' => $user->username,
                                  'paymentMethod' => $paymentMethod,
                                  'plan' => ucfirst($plandetail->plans_name),
                                  'price' => $plandetail->price,
                                  'billing_interval' => $plandetail->billing_interval,
                                  /*'next_billing' => $nextPaymentAttemptDate,*/
                              ), function($message) use ($request,$user,$plan_name,$heading){
                                  $message->from(AdminMail(),GetWebsiteName());
                                  $message->to($user->email, $user->username)->subject( $plan_name .' '. $heading);
                              });
                                          $user->role = 'subscriber';
                                          $user->payment_type = $payment_type;
                                          $user->card_type = 'stripe';
                                          $user->active = 1;
                                          $user->save();
                                          $subscription = Subscription::where('user_id',$user->id)->first();
                                          $subscription->price = $plandetail->price;
                                          $subscription->name = $user->username;
                                          $subscription->days = $plandetail->days;
                                          $subscription->ends_at = $date;
                                          $subscription->regionname = $regionName;
                                          $subscription->countryname = $countryName;
                                          $subscription->cityname = $cityName;
                                          $subscription->save();
                                          $response = array(
                                            'status' => 'success'
                                          );
                                          return response()->json($response);
                          }
                     
                  } catch (IncompletePayment $exception) {
                      return redirect()->route(
                          'cashier.payment',
                          [$exception->payment->id, 'redirect' => route('home')]
                      );
                  }
                
              }
              $response = array(
                'status' => 'success'
              );             
              return response()->json($response);
           
       }
    
       public function Upgrade_Plan()
       {
        $Theme = HomeSetting::pluck('theme_choosen')->first();
        Theme::uses(  $Theme );
        $user = Auth::user();
        $uid = Auth::user()->id;
        $user = User::where('id',$uid)->first();
        $plans = SubscriptionPlan::get();
        $plans_data = $plans->groupBy('plans_name');
        // dd($plans_data);
        $devices = Devices::all();

        Session::put('plans_data ', $plans_data );
          return Theme::view('upgrade', [
            'intent' => $user->createSetupIntent()
           /* ,compact('register')*/
           , compact('plans_data')
           ,'plans_data' => $plans_data
           ,'devices' => $devices
   
          ]);
          
       }

    public function Upgrade()
    {
       $user = Auth::user();
       $uid = Auth::user()->id;
       $user = User::where('id',$uid)->first();
       $plans = SubscriptionPlan::get();
       $plans_data = $plans->groupBy('plans_name');
       // dd($plans_data);
       Session::put('plans_data ', $plans_data );


       if ($user->stripe_id == NULL)
       {
         $stripeCustomer = $user->createAsStripeCustomer();
       }
      /*return view('register.upgrade');*/

      return view('register.upgrade', [
         'intent' => $user->createSetupIntent()
        /* ,compact('register')*/
        , compact('plans_data')
        ,'plans_data' => $plans_data

       ]);
       //$user->subscription('test')->swap('yearly');
        
      //  return View::make('upgrade');
       
    }
    
    public function Upgrade_Subscription(Request $request) {

        
          $user_email = $request->session()->get('register.email');
          $user_id = Auth::User()->id;
          // echo "<pre>";print_r($user_id);
  
          $subscription_user = Subscription::where('user_id',$user_id)->orderBy('created_at', 'DESC')->count();
          if(!empty($subscription_user)){
            $subscription_user = Subscription::where('user_id',$user_id)->orderBy('created_at', 'DESC')->get();
            $date = $subscription_user[0]->ends_at;
            $pervious_date = $date;
          }else{
            $pervious_date = date('Y-m-d H:i:s');
          }
          
          $user = User::where('id',$user_id)->first();
          $user = Auth::user();

          $paymentMethod = $request->get('py_id');
          $plan = $request->get('plan');
          $payment_type = $request->py_id;
          
          // $user->subscription('default')->swap('price_1HWI8oG5RKFecHohjpa5uy7b');
          // exit;
          // $paymentMethods = $user->paymentMethods();
          $stripe_plan = SubscriptionPlan();
          $subscription = $user->subscription($stripe_plan);
          //  print_r($stripe_plan);
          $plandetail = SubscriptionPlan::where('plan_id',$plan)->first();
          $upgrade_plan = ucfirst($plandetail->plans_name);
          $template = EmailTemplate::where('id','=', 24)->first(); 
          $heading = $template->heading; 
          $current_date = $pervious_date;    
          $next_date = $plandetail->days;
          $date = Carbon::parse($current_date)->addDays($next_date);
          // $user->subscription('default')->swapAndInvoice('price_1JpatJDLAfST3GpmWf4b6EMj');
          // $user->subscription('default')->swapAndInvoice('price_1JpatJDLAfST3GpmWf4b6EMj');

          // $user->subscription('price_1JpatIDLAfST3GpmBLYEVXbi')->swap('price_1JpatJDLAfST3Gpm24Ew2CRu');
          // $user->subscription->swapAndInvoice(['prod_JBBTj8CPTb4bXu', 'price_1JpatJDLAfST3GpmWf4b6EMj']);

          $user->subscription('default')->swap('price_1JpatIDLAfST3GpmBLYEVXbi', 'price_1JpatJDLAfST3GpmWf4b6EMj');
          $user->save();

          // $subscription  = $user->subscription('default');
          
          // $subscription->trials_ends_at = null;
          // $subscription->swap('Yearly');
          // prod_JBBTj8CPTb4bXu
          // $user->subscription($stripe_plan)->swap($plandetail->plan_id);

          $plandetail = SubscriptionPlan::where('plan_id',$upgrade_plan)->first();
              \Mail::send('emails.changeplansubscriptionmail', array(
                            'name' => $user->username,
                            'plan' => ucfirst($plandetail->plans_name),
                        ), function($message) use ($request,$user){
                            $message->from(AdminMail(),GetWebsiteName());
                            $message->to($user->email, $user->username)->subject('Subscription Plan Changed');
                });
                // return response()->json(['success'=>'Your plan has been changed.']);
    $response = array(
      'status' => 'success',
      'success'=>'Your plan has been changed.'
    );             
    return response()->json($response);
 
}

public function UpgadeSubscription(Request $request){

    $user_email = Auth::user()->email;
    $user_id = Auth::user()->user_id;
    $user = User::where('email',$user_email)->first();
    $paymentMethod = $request->get('py_id');
    $plan = $request->get('plan');
    $coupon_code = $request->coupon_code;
    $payment_type = $request->payment_type;
    $paymentMethods = $user->paymentMethods();
    $apply_coupon = NewSubscriptionCouponCode();
    $stripe_plan = SubscriptionPlan();
    $plandetail = SubscriptionPlan::where('plan_id',$plan)->first();
    $email_subject = EmailTemplate::where('id',27)->pluck('heading')->first() ;

  // $plandetail = Plan::where('plan_id',$plan)->first();

      if (isset($coupon_code) && $coupon_code !=''){

          try {
                $stripe = new \Stripe\StripeClient(
                  env('STRIPE_SECRET')
                );
                $subscription_details =  $user->newSubscription($stripe_plan, $plan)->withCoupon($apply_coupon)->create($paymentMethod);
                $subscription = $stripe->subscriptions->retrieve( $subscription_details->stripe_id );
                $nextPaymentAttemptDate =  Carbon::createFromTimeStamp( $subscription['current_period_end'] )->format('F jS, Y')  ;

          } 
          catch (IncompletePayment $exception) 
          {
                  return redirect()->route(
                      'cashier.payment',
                      [$exception->payment->id, 'redirect' => route('home')]
                  );
          }

          try {

            \Mail::send('emails.subscriptionmail', array(

                'name'          => ucwords($user->username),
                'plan'          => ucfirst($plandetail->plans_name),
                'price'         => $subscription->plan['amount_decimal'] / 100 ,
                'plan_id'       => $subscription['plan']['id'] ,
                'billing_interval'  => $subscription['plan']['interval'] ,
                'next_billing'      => $nextPaymentAttemptDate,
                'subscription_type' => 'recurring',

            ), function($message) use ($request,$user){
                $message->from(AdminMail(),GetWebsiteName());
                $message->to($user->email, $user->username)->subject($email_subject);
            });

            $email_log      = 'Mail Sent Successfully from Become Subscription';
            $email_template = "23";
            $user_id = $user_id;
      
            Email_sent_log($user_id,$email_log,$email_template);

          } catch (\Throwable $th) {

                  $email_log      = $th->getMessage();
                  $email_template = "23";
                  $user_id = $user_id;
     
                  Email_notsent_log($user_id,$email_log,$email_template);
          }


          $user->role = 'subscriber';
          $user->card_type = 'stripe';
          $user->active = 1;
          $user->payment_type = $payment_type;
          $user->save();
      } 
      else 
      {
        try {
            $stripe = new \Stripe\StripeClient(
              env('STRIPE_SECRET')
            );

            $subscription_details = $user->newSubscription($stripe_plan, $plan)->create($paymentMethod);
            $subscription = $stripe->subscriptions->retrieve( $subscription_details->stripe_id );
            $nextPaymentAttemptDate =  Carbon::createFromTimeStamp( $subscription['current_period_end'] )->format('F jS, Y')  ;

            } 
        catch (IncompletePayment $exception) {
                return redirect()->route(
                    'cashier.payment',
                    [$exception->payment->id, 'redirect' => route('home')]
                );
        }

          try {

            \Mail::send('emails.subscriptionmail', array(
                'name'          => ucwords($user->username),
                'plan'          => ucfirst($plandetail->plans_name),
                'price'         => $subscription->plan['amount_decimal'] / 100 ,
                'plan_id'       => $subscription['plan']['id'] ,
                'billing_interval'  => $subscription['plan']['interval'] ,
                'next_billing'      => $nextPaymentAttemptDate,
                'subscription_type' => 'recurring',

            ), function($message) use ($request,$user,$email_subject){
                $message->from(AdminMail(),GetWebsiteName());
                $message->to($user->email, $user->username)->subject($email_subject);
            });
            
            $email_log      = 'Mail Sent Successfully from Become Subscription';
            $email_template = "23";
            $user_id = $user_id;
      
            Email_sent_log($user_id,$email_log,$email_template);

          } catch (\Throwable $th) {

                  $email_log      = $th->getMessage();
                  $email_template = "23";
                  $user_id = $user_id;
     
                  Email_notsent_log($user_id,$email_log,$email_template);
          }

          $user->role = 'subscriber';
          $user->card_type = 'stripe';
          $user->active = 1;
          $user->payment_type = $payment_type;
          $user->save();
      }

      $response = array('status' => 'success');   
  }


     public function UpgradeSubscription(Request $request)
         {
                $user = Auth::user();
                $upgrade_plan = $request->get('plan_name');
                $coupon_code = $request->get('coupon_code');
                $stripe_plan = SubscriptionPlan();
                $subscription = $user->subscription($stripe_plan);

                $payment_type = $request->payment_type;
                
                 if ( $payment_type == "recurring" ) {
                            if (isset($coupon_code) && !empty($coupon_code))
                              { 
                                  $subscription->swapAndInvoice($upgrade_plan, [
                                      'coupon' => $coupon_code,
                                  ]);
                                  $coupon = new CouponPurchase;
                                  $coupon->coupon_id = $coupon_code;
                                  $coupon->user_id = Auth::user()->id;
                                  $coupon->save();
                              } else {
                                  $subscription->swapAndInvoice($upgrade_plan);
                              }

                            $plan = $request->get('plan_name');
                            $plandetail = SubscriptionPlan::where('plan_id',$plan)->first();

                            try {

                              $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
                              $subscriptions = $stripe->subscriptions->retrieve( $subscription->stripe_id );
                              $nextPaymentAttemptDate =  Carbon::createFromTimeStamp( $subscriptions['current_period_end'] )->format('F jS, Y')  ;
  
                              $Upgrade_subject = EmailTemplate::where('id',24)->pluck('heading')->first() ;

                              \Mail::send('emails.changeplansubscriptionmail', array(
                                          'name'          => ucfirst($user->username),
                                          'plan'          => ucfirst($plandetail->plans_name),
                                          'plan_price'    => $subscriptions->plan['amount_decimal'] / 100 ,
                                          'plan_id'       => $subscriptions['plan']['id'] ,
                                          'billing_interval'  => $subscriptions['plan']['interval'] ,
                                          'next_billing'      => $nextPaymentAttemptDate,
                                          'subscription_type' => 'recurring',
                                          'user_role'         => Auth::user()->role,
  
                                  ), function($message) use ($request,$user,$Upgrade_subject){
                                          $message->from(AdminMail(),GetWebsiteName());
                                          $message->to($user->email, $user->username)->subject($Upgrade_subject);
                                  });

                                  $email_log      = 'Mail Sent Successfully from Upgrade Subscription';
                                  $email_template = "24";
                                  $user_id = $user->id;
                      
                                  Email_sent_log($user_id,$email_log,$email_template);

                            } catch (\Throwable $th) {

                              $email_log      = $th->getMessage();
                              $email_template = "24";
                              $user_id = $user->id;
                
                              Email_notsent_log($user_id,$email_log,$email_template);
                            }

                     
                            $user->role = 'subscriber';
                            $user->payment_type = 'recurring';
                            $user->card_type = 'stripe';
                            $user->save();
                  } else { 
                        $user = Auth::user();
                        $current_date = date('Y-m-d h:i:s');    
                        $user_email = $user->email;
                        $user_id = $user->id;             
                        $price = $request->amount;           
                        $plan_details = Plan::where("plan_id","=",$upgrade_plan)->first();
                        $next_date = $plan_details->days;
                        $date = Carbon::parse($current_date)->addDays($next_date);
                        $sub_price = $plan_details->price;
                        $discount_percentage = DiscountPercentage();
                        $discounted_price = $sub_price - $discount_percentage;
                        $stripe = new \Stripe\StripeClient(env('STRIPE_KEY'));
                        if (isset($coupon_code) && !empty($coupon_code))
                              { 
                                $stripe->charges->create([
                                          'amount' =>  $discounted_price * 100,
                                          'currency' => 'USD',
                                          'source' => $request->stripToken,
                                          'description' => 'New Subscription using One Time subscription method',
                                ]);   
                                    $coupon = new CouponPurchase;
                                    $coupon->coupon_id = $coupon_code;
                                    $coupon->user_id = Auth::user()->id;
                                    $coupon->save();
                              } else {
                                    $stripe->charges->create([
                                          'amount' =>  $sub_price * 100,
                                          'currency' => 'USD',
                                          'source' => $request->stripToken,
                                          'description' => 'New Subscription using One Time subscription method',
                                    ]); 
                              }    
                                $user->role = 'subscriber';
                                $user->payment_type = 'one_time';
                                $user->save();
                                 DB::table('single_subscriptions')->insert([
                                    ['user_id' => $user_id, 'plan_id' => $plan, 'days' => $plan_details->days, 'price' => $plan_details->price, 'to_date' => $date,'from_date' => $current_date,'status' => 'active']
                                ]);
                      return redirect('/')->with( ['data' => "Successfully Updated your subscription"] );
                 }

                    return redirect('/')->with( ['data' => "Successfully Updated your subscription"] );
         }  

        public function become_subscriber(Request $request)
        {

          try {
                $stripe = new \Stripe\StripeClient(
                  env('STRIPE_SECRET')
                );
            
                $paymentMethod = $request->get('py_id');
                $stripe_plan = SubscriptionPlan();
                $plan = $request->get('plan');
                $apply_coupon = $request->get('coupon_code') ?  $request->get('coupon_code') : null ;

                $user=User::where('id',Auth::user()->id)->first();
                $subscription_details = $user->newSubscription( $stripe_plan, $plan )->withCoupon($apply_coupon)->create( $paymentMethod );
                $subscription = $stripe->subscriptions->retrieve( $subscription_details->stripe_id );

                $Sub_Startday  = Carbon::createFromTimestamp($subscription['current_period_start'])->toDateTimeString(); 
                $Sub_Endday    = Carbon::createFromTimestamp($subscription['current_period_end'])->toDateTimeString(); 
                $trial_ends_at = Carbon::createFromTimestamp($subscription['current_period_end'])->toDateTimeString(); 
        
                  Subscription::create([
                    'user_id'        =>  Auth::user()->id,
                    'name'           =>  $subscription->plan['product'],
                    'price'          =>  $subscription->plan['amount_decimal'] / 100,   // Amount Paise to Rupees
                    'stripe_id'      =>  $subscription['id'],
                    'stripe_status'  =>  $subscription['status'],
                    'stripe_plan'    =>  $subscription->plan['id'],
                    'quantity'       =>  $subscription['quantity'],
                    'countryname'    =>  Country_name(),
                    'regionname'     =>  Region_name(),
                    'cityname'       =>  city_name(),
                    'PaymentGateway' =>  'Stripe',
                    'trial_ends_at'  =>  $trial_ends_at,
                    'ends_at'        =>  $trial_ends_at,
                ]);
        
                User::where('id',Auth::user()->id)->update([
                    'role'                  =>  'subscriber',
                    'stripe_id'             =>  $subscription['customer'],
                    'subscription_start'    =>  $Sub_Startday,
                    'subscription_ends_at'  =>  $Sub_Endday,
                    'payment_type'          => 'recurring',
                    'payment_status'        => $subscription['status'],
                ]);

                
                try {

                  $email_subject = EmailTemplate::where('id',23)->pluck('heading')->first() ;
                  $plandetail = SubscriptionPlan::where('plan_id','=',$plan)->first();

                  $nextPaymentAttemptDate =  Carbon::createFromTimeStamp( $subscription['current_period_end'] )->format('F jS, Y')  ;

                  \Mail::send('emails.subscriptionmail', array(

                      'name'          => ucwords($user->username),
                      'paymentMethod' => $paymentMethod,
                      'plan'          => ucfirst($plandetail->plans_name),
                      'price'         => $subscription->plan['amount_decimal'] / 100 ,
                      'plan_id'       => $subscription['plan']['id'] ,
                      'billing_interval'  => $subscription['plan']['interval'] ,
                      'next_billing'      => $nextPaymentAttemptDate,
                      'subscription_type' => 'recurring',
                    ), 

                    function($message) use ($request,$user,$email_subject){
                      $message->from(AdminMail(),GetWebsiteName());
                      $message->to($user->email, $user->username)->subject($email_subject);
                    });

                  $email_log      = 'Mail Sent Successfully from Become Subscription';
                  $email_template = "23";
                  $user_id = $user->id;
      
                  Email_sent_log($user_id,$email_log,$email_template);

              } catch (\Throwable $th) {

                  $email_log      = $th->getMessage();
                  $email_template = "23";
                  $user_id = $user->id;
     
                  Email_notsent_log($user_id,$email_log,$email_template);
              }

              return Redirect::route('home');

          } catch (\Throwable $th) {

                    return Redirect::route('login');
          }
           
        }

      public function retrieve_stripe_coupon(Request $request)
      {
        $stripe = new \Stripe\StripeClient(
          env('STRIPE_SECRET')
        );

        if($request->coupon_code == null )
        {
            $data = array(
              'status' => "false",
              'message' => "Please! Enter the Coupon Code",
              'color'   => "#d70b0b",
              'discount_amt'=>  $request->plan_price,
              'promo_code_amt' => '$0' ,
            );
        }
        else{
            try {
              $coupon = $stripe->coupons->retrieve( $request->coupon_code , []);
              
              if($coupon->amount_off != null){

                $plan_price = str_replace('$', ' ', $request->plan_price);

                $promo_code_amt = $coupon->amount_off / 100 ;

                $discount_amt = $plan_price - $promo_code_amt ;
          
              }
              elseif( $coupon->percent_off != null ){

                  $percentage = $coupon->percent_off;

                  $plan_price = str_replace('$', ' ', $request->plan_price);

                  $promo_code_amt = (($percentage / 100) * $plan_price);

                  $discount_amt = $plan_price -  $promo_code_amt ;
              }


              $data = array(
                'status'      => "true",
                'message'     => "A coupon for ".$coupon->percent_off."% off was successfully applied" ,
                'discount_amt' =>  '$'.$discount_amt,
                'promo_code_amt' => '$'.$promo_code_amt ,
                'color'       => "#008b00",
              );
            }
            catch (\Throwable $th) {

              $data = array(
                'status' => "false",
                'message' => "Invalid Coupon! Please Enter the Valid Coupon Code"  ,
                'discount_amt'=>  $request->plan_price,
                'color'   => "#d70b0b",
                'promo_code_amt' => '$0' ,
              );
            }
        }
        return response()->json($data, 200);
      }

      public function retrieve_stripe_invoice(Request $request)
      {

        $stripe = new \Stripe\StripeClient(
          env('STRIPE_SECRET')
        );

       $stripe_plan =  $stripe->coupons->retrieve('kH98CHkw', []);
       
       dd($stripe_plan);

      }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Used to process plans
use PayPal\Api\ChargeModel;
use PayPal\Api\Currency;
use PayPal\Api\MerchantPreferences;
use PayPal\Api\PaymentDefinition;
use PayPal\Api\Plan;
use PayPal\Api\Patch;
use PayPal\Api\PatchRequest;
use PayPal\Common\PayPalModel;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;

// use to process billing agreements
use PayPal\Api\Agreement;
use PayPal\Api\Payer;
use PayPal\Api\ShippingAddress;
use PayPal\Api\Amount;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use App\Video;
use App\ModeratorsUser;
use App\VideoCommission;
use App\Channel;
use App\PpvPurchase;

class PaypalController extends Controller
{
    private $apiContext;
    private $mode;
    private $client_id;
    private $secret;
    
    // Create a new instance with our paypal credentials
    public function __construct()
    {
        // // Detect if we are running in live mode or sandbox
        if(config('paypal.settings.mode') == 'live'){
            $this->client_id = config('paypal.live_client_id');
            $this->secret = config('paypal.live_secret');
        } else {
            $this->client_id = config('paypal.sandbox_client_id');
            $this->secret = config('paypal.sandbox_secret');
        }
        
        // Set the Paypal API Context/Credentials
        $this->apiContext = new ApiContext(new OAuthTokenCredential($this->client_id, $this->secret));
        $this->apiContext->setConfig(config('paypal.settings'));

        // $this->apiContext = new ApiContext(
        //     new OAuthTokenCredential(
        //         config('services.paypal.client_id'),
        //         config('services.paypal.secret')
        //     )
        // );

        // $this->apiContext->setConfig(config('services.paypal.settings'));

    }

    public function create_plan(){

        // Create a new billing plan
        $plan = new Plan();
        $plan->setName('App Name Monthly Billing')
          ->setDescription('Monthly Subscription to the App Name')
          ->setType('infinite');

        // Set billing plan definitions
        $paymentDefinition = new PaymentDefinition();
        $paymentDefinition->setName('Regular Payments')
          ->setType('REGULAR')
          ->setFrequency('Month')
          ->setFrequencyInterval('1')
          ->setCycles('0')
          ->setAmount(new Currency(array('value' => 9, 'currency' => 'USD')));

        // Set merchant preferences
        $merchantPreferences = new MerchantPreferences();
        $merchantPreferences->setReturnUrl('https://website.dev/subscribe/paypal/return')
          ->setCancelUrl('https://website.dev/subscribe/paypal/return')
          ->setAutoBillAmount('yes')
          ->setInitialFailAmountAction('CONTINUE')
          ->setMaxFailAttempts('0');

        $plan->setPaymentDefinitions(array($paymentDefinition));
        $plan->setMerchantPreferences($merchantPreferences);

        //create the plan
        try {
            $createdPlan = $plan->create($this->apiContext);

            try {
                $patch = new Patch();
                $value = new PayPalModel('{"state":"ACTIVE"}');
                $patch->setOp('replace')
                  ->setPath('/')
                  ->setValue($value);
                $patchRequest = new PatchRequest();
                $patchRequest->addPatch($patch);
                $createdPlan->update($patchRequest, $this->apiContext);
                $plan = Plan::get($createdPlan->getId(), $this->apiContext);

                // Output plan id
                echo 'Plan ID:' . $plan->getId();
            } catch (PayPal\Exception\PayPalConnectionException $ex) {
                echo $ex->getCode();
                echo $ex->getData();
                die($ex);
            } catch (Exception $ex) {
                die($ex);
            }
        } catch (PayPal\Exception\PayPalConnectionException $ex) {
            echo $ex->getCode();
            echo $ex->getData();
            die($ex);
        } catch (Exception $ex) {
            die($ex);
        }

    }

    public function paypalRedirect(){

        // dd($this->client_id);

        // Create new agreement
        // $agreement = new Agreement();
        // $agreement->setName('Monthly Subscription')
        //   ->setDescription('Basic Subscription')
        //   ->setStartDate(\Carbon\Carbon::now()->addMinutes(5)->toIso8601String());
        
        // $this->plan_id =  'P-6XA79361YH9914942MMPN3BQ';

        // // Set plan id
        // $plan = new Plan();
        // $plan->setId($this->plan_id);
        // $agreement->setPlan($plan);

        // // Add payer type
        // $payer = new Payer();
        // $payer->setPaymentMethod('paypal');
        // $agreement->setPayer($payer);

        // try {
        //   // Create agreement
        //   $agreement = $agreement->create($this->apiContext);

        //   // Extract approval URL to redirect user
        //   $approvalUrl = $agreement->getApprovalLink();

        //   return redirect($approvalUrl);
        // } catch (PayPal\Exception\PayPalConnectionException $ex) {
        //   echo $ex->getCode();
        //   echo $ex->getData();
        //   die($ex);
        // } catch (Exception $ex) {
        //   die($ex);
        // }
        $data = array(
            'client_id' => $this->client_id,
            'secret' => $this->secret,

        );
        return \View::make('paypal', $data); 
    }

    public function paypalReturn(Request $request){
        // dd('test');
        $token = $request->token;
        $agreement = new \PayPal\Api\Agreement();

        try {
            // Execute agreement
            $result = $agreement->execute($token, $this->apiContext);
            $user = Auth::user();
            $user->role = 'subscriber';
            $user->paypal = 1;
            if(isset($result->id)){
                $user->paypal_agreement_id = $result->id;
            }
            $user->save();

            echo 'New Subscriber Created and Billed';

        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            echo 'You have either cancelled the request or your session has expired';
        }
    }

    public function PayPalSubscription(Request $request){

        // GeoIPLocation
        
        $current_date = date('Y-m-d h:i:s');    
        $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
        $userIp = $geoip->getip();    
        $countryName = $geoip->getCountry();
        $regionName = $geoip->getregion();
        $cityName = $geoip->getcity();

        // Data from Request

        $settings = $settings = \App\Setting::first();/*Setting::first()*/
        $user_email = $request->session()->get('register.email');
        $user = User::where('email',$user_email)->first();
        $paymentMethod = $request->get('py_id');
        $subscriptionID = $request->get('subscriptionID');
        $plan = $request->get('plan');
        $plandetail = SubscriptionPlan::where('plan_id','=',$plan)->first();
        $payment_type = $plandetail->payment_type;

        // update user subscriber
        $user->role = 'subscriber';
        $user->payment_type = 'on_time';
        $user->card_type = 'paypal';
        $user->active = 1;
        $user->paypal_agreement_id = $subscriptionID;
        $user->subscription_start = Carbon::now(); 
        $user->save();

        // adding subscription data 

        $next_date = $plandetail->days;
        $date = Carbon::parse($current_date)->addDays($next_date);
        // $subscription = Subscription::where('user_id',$user->id)->first();
        $purchase = new Subscription;
        $subscription->price = $plandetail->price;
        $subscription->name = $user->username;
        $subscription->days = $plandetail->days;
        $subscription->regionname = $regionName;
        $subscription->countryname = $countryName;
        $subscription->cityname = $cityName;
        $subscription->ends_at = $date;
        $subscription->platform = 'WebSite';
        $subscription->save();

        $response = array(
            'status' => 'success'
        );

        return response()->json($response);

    }

    public function createPayment(Request $request)
    {
        $apiContext = $this->apiContext;

        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $amount = new Amount();
        $amount->setTotal(10.00); // Set the total amount
        $amount->setCurrency('USD'); // Set the currency

        $transaction = new Transaction();
        $transaction->setAmount($amount);
        $transaction->setDescription('Your payment description');

        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl(url('/paypal/execute-payment')); // Set your return URL
        $redirectUrls->setCancelUrl(url('/')); // Set your cancel URL

        $payment = new Payment();
        $payment->setIntent('sale');
        $payment->setPayer($payer);
        $payment->setTransactions([$transaction]);
        $payment->setRedirectUrls($redirectUrls);

        try {
            $payment->create($apiContext);
            // Redirect the user to PayPal for approval
            return redirect($payment->getApprovalLink());
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }

    public function executePayment(Request $request)
    {
        $apiContext = $this->apiContext;

        $paymentId = $request->input('paymentId');
        $payerId = $request->input('PayerID');

        $payment = Payment::get($paymentId, $apiContext);

        $execution = new PaymentExecution();
        $execution->setPayerId($payerId);

        try {
            $result = $payment->execute($execution, $apiContext);

            // Handle the successful payment execution
            // You can store payment information or perform other actions here

            return response()->json(['success' => 'Payment completed successfully']);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }


}
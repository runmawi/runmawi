<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Validator;
use URL;
use Session;
use Redirect;
use Input;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\ExecutePayment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;
use PayPal\Api\Agreement;
use PayPal\Api\Plan;
use PayPal\Api\PaymentDefinition;
use PayPal\Api\PayerInfo;

class PaypalController extends Controller
{
    private $apiContext;
    private $mode;
    private $client_id;
    private $secret;
    public function __construct()
    {
            
        $paypal_configuration = \Config::get('paypal');
        $this->apiContext = new ApiContext(new OAuthTokenCredential($paypal_configuration['client_id'], $paypal_configuration['secret']));
        $this->apiContext->setConfig($paypal_configuration['settings']);
        // $this->apiContext = new ApiContext(new OAuthTokenCredential($this->client_id, $this->secret));
        // $this->apiContext->setConfig(config('paypal.settings'));
    }

    public function payWithPaypal()
    {
        return view('paywithpaypal');
    }

    // public function postPaymentWithpaypal(Request $request)
    // {
        
    //     $payer = new Payer();
    //     $payer->setPaymentMethod('paypal');

    // 	$item_1 = new Item();

    //     $item_1->setName('Product 1')
    //         ->setCurrency('USD')
    //         ->setQuantity(1)
    //         ->setPrice($request->get('amount'));

    //     $item_list = new ItemList();
    //     $item_list->setItems(array($item_1));

    //     $amount = new Amount();
    //     $amount->setCurrency('USD')
    //         ->setTotal($request->get('amount'));

    //     $transaction = new Transaction();
    //     $transaction->setAmount($amount)
    //         ->setItemList($item_list)
    //         ->setDescription('Enter Your transaction description');

    //     $redirect_urls = new RedirectUrls();
    //     $redirect_urls->setReturnUrl(URL::route('status'))
    //         ->setCancelUrl(URL::route('status'));

    //     $payment = new Payment();
    //     $payment->setIntent('Sale')
    //         ->setPayer($payer)
    //         ->setRedirectUrls($redirect_urls)
    //         ->setTransactions(array($transaction));            
    //     try {
    //         $payment->create($this->_api_context);
    //     } catch (\PayPal\Exception\PPConnectionException $ex) {
    //         if (\Config::get('app.debug')) {
    //             \Session::put('error','Connection timeout');
    //             return Redirect::route('paywithpaypal');                
    //         } else {
    //             \Session::put('error','Some error occur, sorry for inconvenient');
    //             return Redirect::route('paywithpaypal');                
    //         }
    //     }

    //     foreach($payment->getLinks() as $link) {
    //         if($link->getRel() == 'approval_url') {
    //             $redirect_url = $link->getHref();
    //             break;
    //         }
    //     }
        
    //     Session::put('paypal_payment_id', $payment->getId());

    //     if(isset($redirect_url)) {            
    //         return Redirect::away($redirect_url);
    //     }

    //     \Session::put('error','Unknown error occurred');
    // 	return Redirect::route('paywithpaypal');
    // }

    // public function getPaymentStatus(Request $request)
    // {        
    //     $payment_id = Session::get('paypal_payment_id');

    //     Session::forget('paypal_payment_id');
    //     if (empty($request->input('PayerID')) || empty($request->input('token'))) {
    //         \Session::put('error','Payment failed');
    //         return Redirect::route('paywithpaypal');
    //     }
    //     $payment = Payment::get($payment_id, $this->_api_context);        
    //     $execution = new PaymentExecution();
    //     $execution->setPayerId($request->input('PayerID'));        
    //     $result = $payment->execute($execution, $this->_api_context);
        
    //     if ($result->getState() == 'approved') {         
    //         \Session::put('success','Payment success !!');
    //         return Redirect::route('paywithpaypal');
    //     }

    //     \Session::put('error','Payment failed !!');
	// 	return Redirect::route('paywithpaypal');
    // }



    // public function create_plan(){

    //     // Create a new billing plan
    //     $plan = new Plan();
    //     $plan->setName('App Name Monthly Billing')
    //       ->setDescription('Monthly Subscription to the App Name')
    //       ->setType('infinite');

    //     // Set billing plan definitions
    //     $paymentDefinition = new PaymentDefinition();
    //     $paymentDefinition->setName('Regular Payments')
    //       ->setType('REGULAR')
    //       ->setFrequency('Month')
    //       ->setFrequencyInterval('1')
    //       ->setCycles('0')
    //       ->setAmount(new Currency(array('value' => 9, 'currency' => 'USD')));

    //     // Set merchant preferences
    //     $merchantPreferences = new MerchantPreferences();
    //     $merchantPreferences->setReturnUrl('https://website.dev/subscribe/paypal/return')
    //       ->setCancelUrl('https://website.dev/subscribe/paypal/return')
    //       ->setAutoBillAmount('yes')
    //       ->setInitialFailAmountAction('CONTINUE')
    //       ->setMaxFailAttempts('0');

    //     $plan->setPaymentDefinitions(array($paymentDefinition));
    //     $plan->setMerchantPreferences($merchantPreferences);

    //     //create the plan
    //     try {
    //         $createdPlan = $plan->create($this->apiContext);

    //         try {
    //             $patch = new Patch();
    //             $value = new PayPalModel('{"state":"ACTIVE"}');
    //             $patch->setOp('replace')
    //               ->setPath('/')
    //               ->setValue($value);
    //             $patchRequest = new PatchRequest();
    //             $patchRequest->addPatch($patch);
    //             $createdPlan->update($patchRequest, $this->apiContext);
    //             $plan = Plan::get($createdPlan->getId(), $this->apiContext);

    //             // Output plan id
    //             echo 'Plan ID:' . $plan->getId();
    //         } catch (PayPal\Exception\PayPalConnectionException $ex) {
    //             echo $ex->getCode();
    //             echo $ex->getData();
    //             die($ex);
    //         } catch (Exception $ex) {
    //             die($ex);
    //         }
    //     } catch (PayPal\Exception\PayPalConnectionException $ex) {
    //         echo $ex->getCode();
    //         echo $ex->getData();
    //         die($ex);
    //     } catch (Exception $ex) {
    //         die($ex);
    //     }

    



    public function paypalRedirect(){
        // Create new agreement
        $plan_id = session()->get('plan_id');
        $planname = session()->get('planname');

        $agreement = new Agreement();

        $agreement->setName($planname)
          ->setDescription('Subscription')
          ->setStartDate(\Carbon\Carbon::now()->addMinutes(5)->toIso8601String());


        // Set plan id
        $plan = new Plan();
        $plan->setId($plan_id);
        dd($this->apiContext);

        $agreement->setPlan($plan);

        // Add payer type
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
        $agreement->setPayer($payer);

        try {
          // Create agreement
          $agreement = $agreement->create($this->apiContext);

          // Extract approval URL to redirect user
          $approvalUrl = $agreement->getApprovalLink();

          return redirect($approvalUrl);
        } catch (PayPal\Exception\PayPalConnectionException $ex) {
          echo $ex->getCode();
          echo $ex->getData();
          die($ex);
        } catch (Exception $ex) {
          die($ex);
        }

    }

    public function paypalReturn(Request $request){

        $id = session()->get('user_id');

        $token = $request->token;
        $agreement = new \PayPal\Api\Agreement();

        try {
            // Execute agreement
            $result = $agreement->execute($token, $this->apiContext);
            $user = User::where('id',$id)->first();
            $user = Auth::user();
            $user->role = 'subscriber';
            $user->payment_type = 'recurring';
            $user->card_type = 'paypal';
            $user->active = 1;
            // $user->paypal = 1;
            if(isset($result->id)){
                $user->paypal_agreement_id = $result->id;
            }
            $user->save();

            echo 'New Subscriber Created and Billed';

        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            echo 'You have either cancelled the request or your session has expired';
        }
    }                                                                                   







    // https://devdojo.com/tnylea/using-paypal-in-your-laravel-app


}
<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Recurly\Client as RecurlyClient ;
use App\HomeSetting ;
use Theme;

class RecurlyPaymentController extends Controller
{
  
    protected $HomeSetting;

    public function __construct()
    {
        $this->HomeSetting = HomeSetting::first();
        Theme::uses($this->HomeSetting->theme_choosen);

        $this->api_key = '50a7c9a54a2241ee998eb9ec83d3d302';
        $this->client = new RecurlyClient($this->api_key);
    }

    public function checkout_page(Request $request)
    {

        $data = array(
            'current_theme'     => $this->HomeSetting->theme_choosen,
        );

        return Theme::view('Recurly.checkout_page', $data);
       
    }

    public function subscription(Type $var = null)
    {
        # code...
    }

    public function plans_code()
    {
        // $plan_add_ons = $this->client->getPlan('vaa5difepuf3');

        // vaa5difepuf3 

        // $planUpdate = [
        //     "name" => "Monthly dd Subscription",
        //     "hosted_pages" => [
        //         "success_url" => "https://localhost/flicknexs/recurly/checkout-page",
        //         "cancel_url" => "https://localhost/flicknexs/recurly/checkout-page",
        //         "bypass_confirmation" => true,
        //         "display_quantity" => true
        //     ],
        //     "currencies" => [
        //         [
        //             "currency" => "INR",
        //             "unit_amount" => 10.00  // Set the appropriate unit amount for the currency
        //         ]
        //     ]
        // ];
        
        $plan = $this->client->getPlan('vaa5difepuf3');
        
          
        dd($plan->getHostedPages() );
    }
}
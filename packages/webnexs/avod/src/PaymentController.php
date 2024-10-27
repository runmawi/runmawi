<?php

namespace Webnexs\Avod;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Validator, Redirect, Response;
use Carbon\Carbon;
use App\AdvertiserSubscription;
use App\PaymentSetting;
use App\Advertiser;
use App\Adsplan;
use Theme;

class PaymentController extends Controller
{
    public function Payment_details(Request $request)
    {
        try {
            
            if (empty(session('advertiser_id'))) { 
                return Redirect::to('advertiser/login')->withErrors(['Opps! You do not have access']);
            }

            $Advertiser = Advertiser::where('id', session('advertiser_id'))->where('status', 1)->first();

            $Adsplan = Adsplan::where('status',1)->get();
    
            $Stripe_payment_settings = PaymentSetting::where('payment_type', 'Stripe')->first();
    
            $Advertiser = Advertiser::where('id', session('advertiser_id'))->where('status', 1)->first();
    
            $data = array(
                'Adsplan' => $Adsplan ,
                'Advertiser' => $Advertiser,
                'Stripe_payment_settings' => $Stripe_payment_settings ,
            );
    
            return view('avod::Payment.index',$data);

        } catch (\Throwable $th) {

            return abort(404);
        }
    }
    
    public function transaction_details(Request $request)
    {
        try {

            if (empty(session('advertiser_id'))) { 
                return Redirect::to('advertiser/login')->withErrors(['Opps! You do not have access']);
            }
           
            $data = array(
                'adverister_subscription' => AdvertiserSubscription::where('adverister_id',session('advertiser_id'))->get(),
            );
            
            return view('avod::Payment.transaction_details',$data);

        } catch (\Throwable $th) {
            
            return abort(404);
        }
    }
}
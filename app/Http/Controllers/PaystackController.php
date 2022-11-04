<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Notification;
use \Redirect as Redirect;
use Illuminate\Support\Str;
use Session;
use Theme;
use Auth;
use Carbon\Carbon;
use App\Subscription;
use Razorpay\Api\Api;
use App\User;
use App\ThemeIntegration;
use App\PaymentSetting;
use URL;
use App\ModeratorsUser;
use App\VideoCommission;
use App\PpvPurchase;
use App\Video;
use App\Setting;
use App\LivePurchase;
use App\LiveStream;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use AmrShawky\LaravelCurrency\Facade\Currency as PaymentCurreny;
use App\ModeratorPayout;
use App\ChannelPayout;
use App\Channel;

class PaystackController extends Controller
{
    public function __construct()
    {
        $PaymentSetting = PaymentSetting::where('payment_type','Paystack')->first();

        if( $PaymentSetting != null ){

            if( $PaymentSetting->live_mode == 0 ){
                $this->paystack_keyId = $PaymentSetting->paystack_test_publishable_key;
                $this->paystack_keysecret = $PaymentSetting->paystack_test_secret_key;
            }else{
                $this->paystack_keyId = $PaymentSetting->paystack_live_publishable_key;
                $this->paystack_keysecret = $PaymentSetting->paystack_live_secret_key;
            }
        }else{
            $Error_msg = "Paystack Key is Missing";
            $url = URL::to('/home');
            echo "<script type='text/javascript'>alert('$Error_msg'); window.location.href = '$url' </script>";
        }
    }

    public function paystack(Request $request)
    {
        return view('Razorpay.create');
    }
}

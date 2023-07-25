<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use \App\User as User;
use \Redirect as Redirect;
use URL;
use App\Video as Video;
use App\Plan as Plan;
use App\VideoCategory as VideoCategory;
use App\VideoResolution as VideoResolution;
use App\VideosSubtitle as VideosSubtitle;
use App\Language as Language;
use App\Subtitle as Subtitle;
use App\Tag as Tag;
use App\Coupon as Coupon;
use Auth;
use Hash;
use Illuminate\Support\Facades\Cache;
use Image;
use View;
use Response;
use App\Currency;
use App\CurrencySetting;
use App\Setting;
use DB;
use GuzzleHttp\Client;

class AdminCurrencySettings extends Controller
{
    public function IndexCurrencySettings()
    {
        if(!Auth::guest() && Auth::user()->package == 'Channel' ||  Auth::user()->package == 'CPP'){
            return redirect('/admin/restrict');
        }
        
        $user =  User::where('id',1)->first();
        $duedate = $user->package_ends;
        $current_date = date('Y-m-d');
        if ($current_date > $duedate)
        {
            $client = new Client();
            $url = "https://flicknexs.com/userapi/allplans";
            $params = [
                'userid' => 0,
            ];
    
            $headers = [
                'api-key' => 'k3Hy5qr73QhXrmHLXhpEh6CQ'
            ];
            $response = $client->request('post', $url, [
                'json' => $params,
                'headers' => $headers,
                'verify'  => false,
            ]);
    
            $responseBody = json_decode($response->getBody());
           $settings = Setting::first();
           $data = array(
            'settings' => $settings,
            'responseBody' => $responseBody,
    );
            return View::make('admin.expired_dashboard', $data);
        }else if(check_storage_exist() == 0){
            $settings = Setting::first();

            $data = array(
                'settings' => $settings,
            );

            return View::make('admin.expired_storage', $data);
        }else{
         $currency = Currency::get();
         $allCurrency = CurrencySetting::get();


        
         $data = array(
                   'currency' => $currency  ,
                   'allCurrency' => $allCurrency        	

         );
        return view('admin.currency.index',$data);
        }
    }


    public function StoreCurrencySettings(Request $request)
    {
        $input = $request->all();
         $currency = Currency::where('country','=',$input['country'])->first();
        //  dd($currency);

         $Currencysetting = new CurrencySetting;

         $Currencysetting->country = $currency->country;
         $Currencysetting->symbol = $currency->symbol;
         $Currencysetting->user_id = Auth::User()->id;
         $Currencysetting->save();
         return Redirect::back();
 
    }

    public function UpdateCurrencySettings(Request $request)
    {
        $input = $request->all();
        $currency = Currency::where('country','=',$input['country'])->first();
        $id = $input['id'];

        //  dd($currency->symbol);
        // CurrencySetting::truncate();

         $Currencysetting = CurrencySetting::find($id);        

        //  $Currencysetting = new CurrencySetting;

         $Currencysetting->country = $currency->country;
         $Currencysetting->symbol = $currency->symbol;
         $Currencysetting->user_id = Auth::User()->id;
         $Currencysetting->save();

         return Redirect::back();
    }


    public function EditCurrencySettings($id)
    {
        if(!Auth::guest() && Auth::user()->package == 'Channel' ||  Auth::user()->package == 'CPP'){
            return redirect('/admin/restrict');
        }

        $user =  User::where('id',1)->first();
        $duedate = $user->package_ends;
        $current_date = date('Y-m-d');
        if ($current_date > $duedate)
        {
            $client = new Client();
            $url = "https://flicknexs.com/userapi/allplans";
            $params = [
                'userid' => 0,
            ];
    
            $headers = [
                'api-key' => 'k3Hy5qr73QhXrmHLXhpEh6CQ'
            ];
            $response = $client->request('post', $url, [
                'json' => $params,
                'headers' => $headers,
                'verify'  => false,
            ]);
    
            $responseBody = json_decode($response->getBody());
           $settings = Setting::first();
           $data = array(
            'settings' => $settings,
            'responseBody' => $responseBody,
    );
            return View::make('admin.expired_dashboard', $data);
        }else if(check_storage_exist() == 0){
            $settings = Setting::first();

            $data = array(
                'settings' => $settings,
            );

            return View::make('admin.expired_storage', $data);
        }else{
        $allCurrency = CurrencySetting::first();
        $Currency_symbol = Currency::where('country',Country_name())->pluck('code')->first();

        $default_Currency = Currency::where('country',@$allCurrency->country)->pluck('code')->first();

        // https://api.exchangerate.host/latest?base=usd&symbols=USD,EUR,GBP,JPY,SGD,AUD
        $response = \Http::get('https://api.exchangerate.host/latest', [
            'base' => @$default_Currency,
            'symbols' => @$allCurrency->symbol,
        ]);
        // dd(  $response   );

        $client = new Client();
        $url = "https://api.exchangerate.host/latest";
        $params = [
            'base' => @$default_Currency,
            'symbols' => @$allCurrency->symbol,
        ];

        $headers = [
            'api-key' => 'k3Hy5qr73QhXrmHLXhpEh6CQ'
        ];
        $response = $client->request('get', $url, [
            'json' => $params,
            'headers' => $headers,
            'verify'  => false,
        ]);

        $responseBody = json_decode($response->getBody());
        // $responseBody->rates->$Currency_symbol
        // dd(  $responseBody->rates->$default_Currency );
        // ->NGN 876.389432 INR
         $currency = Currency::get();
        
         $data = array(
                   'currency' => $currency , 
                   'allCurrency' => $allCurrency        	

         );
        return view('admin.currency.edit',$data);
        }
    }


    public function DeleteCurrencySettings($id)
    {
        
        CurrencySetting::destroy($id);
        
         return Redirect::back();
    }

    
}

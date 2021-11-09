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
use DB;

class AdminCurrencySettings extends Controller
{
    public function IndexCurrencySettings()
    {
        
         $currency = DB::table('currencies')->get();
         $allCurrency = CurrencySetting::get();


        
         $data = array(
                   'currency' => $currency  ,
                   'allCurrency' => $allCurrency        	

         );
        return view('admin.currency.index',$data);
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

        //  dd($currency);
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
        
        $allCurrency = CurrencySetting::where('id','=',$id)->first();
        // dd($allCurrency->country);
         $currency = DB::table('currencies')->get();
        
         $data = array(
                   'currency' => $currency , 
                   'allCurrency' => $allCurrency        	

         );
        return view('admin.currency.edit',$data);
    }


    public function DeleteCurrencySettings($id)
    {
        
        CurrencySetting::destroy($id);
        
         return Redirect::back();
    }

    
}

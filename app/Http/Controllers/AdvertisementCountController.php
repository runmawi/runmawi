<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\AdsRedirectionURLCount ;
use App\AdsViewCount ;

class AdvertisementCountController extends Controller
{
    public function Advertisement_Redirection_URL_Count(Request $request)
    {
        $inputs = array(
            "Count" => 1 , 
            "source_type" => $request->source_type,
            "source_id"   =>  $request->source_id ,
            "adverister_id" =>  $request->adverister_id ,
            "adveristment_id" =>  $request->adveristment_id ,
            "timestamp_time" => $request->timestamp_time ,
            "user" =>  $request->user ,
        );
      
        AdsRedirectionURLCount::create($inputs);
    }

    public function Advertisement_Views_Count(Request $request)
    {
        $inputs = array(
            "Count" => 1 , 
            "source_type" => "$request->source_type",
            "source_id"   =>  $request->source_id ,
            "adverister_id" =>  $request->adverister_id ,
            "adveristment_id" =>  $request->adveristment_id ,
            "user" =>  $request->user ,
        );

        AdsViewCount::create($inputs);
    }
}

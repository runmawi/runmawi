<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Victorybiz\GeoIPLocation\GeoIPLocation;
use App\AdsRedirectionURLCount ;
use App\AdsViewCount ;
use App\Advertisement ;

class AdvertisementCountController extends Controller
{
    public function __construct()
    {
        $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
        $this->userIp = $geoip->getip();
    }

    public function Advertisement_Redirection_URL_Count(Request $request)
    {

        $adverister_id = Advertisement::where('id',$request->adveristment_id)->pluck('advertiser_id')->first();

        $inputs = array(
            "Count"         =>  1 , 
            "user"          =>  $request->user ,
            "source_type"   =>  $request->source_type,
            "source_id"     =>  $request->source_id ,
            "adverister_id" =>  $adverister_id ,
            "adveristment_id" =>  $request->adveristment_id ,
            "timestamp_time"  =>  $request->timestamp_time ,
            "IP_address"      =>  $this->userIp,
            "country"         => Country_name(),
            "city"            => city_name(),
        );
      
        AdsRedirectionURLCount::create($inputs);
    }

    public function Advertisement_Views_Count(Request $request)
    {
        $adverister_id = Advertisement::where('id',$request->adveristment_id)->pluck('advertiser_id')->first();

        $inputs = array(
            "Count"         =>  1 , 
            "user"          =>  $request->user ,
            "source_type"   =>  $request->source_type,
            "source_id"     =>  $request->source_id ,
            "adverister_id" =>  $adverister_id ,
            "adveristment_id" =>  $request->adveristment_id ,
            "IP_address"      =>  $this->userIp,
            "country"         =>  Country_name(),
            "city"            =>  city_name(),
        );

        AdsViewCount::create($inputs);
    }
}
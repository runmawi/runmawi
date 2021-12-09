<?php

namespace App\Http\Controllers;

use App\Advertiser as Advertiser;
use App\Adscategory as Adscategory;
use App\Setting as Setting;
use App\Adsplan as Adsplan;
use App\Advertisement as Advertisement;
use App\User as User;
use App\Advertiserplanhistory as Advertiserplanhistory;
use \Redirect as Redirect;
use Illuminate\Http\Request;
use DB;


class AdminAdvertiserController extends Controller
{
  public function advertisers()
  {
    $setting = Setting::first();
    if($setting->ads_on_videos == 1){
      $data = array(
        'advertisers' => Advertiser::orderBy('created_at', 'desc')->paginate(9),
      );
      return view('admin.ads_management.advertiser_list',$data);
    }else{
      return abort(404);
    }
  }

  public function ads_categories()
  {
    $setting = Setting::first();
    if($setting->ads_on_videos == 1){
      $data = array(
        'ads_categories' => Adscategory::orderBy('created_at', 'desc')->paginate(9),
      );
      return view('admin.ads_management.ads_categories_list',$data);
    }else{
      return abort(404);
    }
  }

  public function ads_list()
  {
    $setting = Setting::first();
    if($setting->ads_on_videos == 1){
      $data = array(
        'advertisements' => Advertisement::orderBy('created_at', 'desc')->paginate(9),
      );
      return view('admin.ads_management.ads_list',$data);
    }else{
      return abort(404);
    }
  }

  
  public function save_ads_status(Request $request)
  {
    $data = $request->all();
    $id = $data['id'];
    $status = $data['status'];
    $Ads = Advertisement::find($id);
    $Ads->status = $status;
    $Ads->save();
    $advertiser_emailid = Advertiser::find($Ads->advertiser_id)->email_id;
    $customerName = Advertiser::find($Ads->advertiser_id)->company_name;
    $adminemail = User::where('role','=','admin')->first()->email;
    $adname = Advertisement::find($id)->ads_name;
    if($status == 1){
      $details = [
        'title' => "Dear " .$customerName,
        'body' => "We are thrilled to have you on board.\n
        Your ".$adname." has been Approved. \n
        Log in to the Ad panel to explore more!Your Admin Panel: #PartnerUrl\n
        Login email address: #PartnerEmail\n
        Please write to us at ".$adminemail." for queries and suggestions."
      ];

      \Mail::to($advertiser_emailid)->send(new \App\Mail\MyTestMail($details));
    }
    return response()->json([ 'success' => true ]);
  }

  public function ads_plans()
  {
    $setting = Setting::first();
    if($setting->ads_on_videos == 1){
      $data = array(
        'ads_plans' => Adsplan::orderBy('created_at', 'desc')->paginate(9),
      );
      return view('admin.ads_management.ads_plans_list',$data);
    }else{
      return abort(404);
    }
  }

  public function add_ads_category(Request $request)
  {
    $data = $request->all();
    $Adscategory = new Adscategory;
    $Adscategory->name = $request->name;
    $Adscategory->save();
    return response()->json([ 'success' => true ]);
  }

  public function edit_ads_category(Request $request)
  {
    $data = $request->all();
    $id = $data['id'];
    $Adscategory = Adscategory::find($id);
    $Adscategory->name = $request->name;
    $Adscategory->save();
    return response()->json([ 'success' => true ]);
  }

  public function adscategoryedit($id)
  {
    $Adscategory = Adscategory::find($id);

    return response()->json([
      'data' => $Adscategory
    ]);
  }

  public function ads_category_delete($id)
  {
    Adscategory::find($id)->delete();

    return response()->json([ 'success' => true ]);
  }


  public function add_ads_plan(Request $request)
  {
    $data = $request->all();
    $Adsplan = new Adsplan;
    $Adsplan->plan_name = $request->plan_name;
    $Adsplan->plan_amount = $request->plan_amount;
    $Adsplan->no_of_ads = $request->no_of_ads;
    $Adsplan->save();
    return response()->json([ 'success' => true ]);
  }

  public function edit_ads_plan(Request $request)
  {
    $data = $request->all();
    $id = $data['id'];
    $Adsplan = Adsplan::find($id);
    $Adsplan->plan_name = $request->plan_name;
    $Adsplan->plan_amount = $request->plan_amount;
    $Adsplan->no_of_ads = $request->no_of_ads;
    $Adsplan->save();
    return response()->json([ 'success' => true ]);
  }

  public function adsplanedit($id)
  {
    $Adsplan = Adsplan::find($id);

    return response()->json([
      'data' => $Adsplan
    ]);
  }

  public function ads_plan_delete($id)
  {
    Adsplan::find($id)->delete();

    return response()->json([ 'success' => true ]);
  }

  public function ads_revenue()
  {
    $setting = Setting::first();
    if($setting->ads_on_videos == 1){
      
      // $ads_data = DB::table('advertiser_plan_history')
      // ->join('advertisers', 'advertiser_plan_history.advertiser_id', '=', 'advertisers.id')
      // ->join('ads_plans', 'advertiser_plan_history.plan_id', '=', 'ads_plans.id')
      // ->select('advertiser_plan_history.*', 'advertisers.company_name', 'ads_plans.plan_amount', 'ads_plans.plan_name')
      // ->get();
      
      $ads_data = Advertiserplanhistory::join('advertisers', 'advertiser_plan_history.advertiser_id', '=', 'advertisers.id')
      ->join('ads_plans', 'advertiser_plan_history.plan_id', '=', 'ads_plans.id')
      ->select('advertiser_plan_history.*', 'advertisers.company_name', 'ads_plans.plan_amount', 'ads_plans.plan_name')
      ->get();
      
      $data = array(
        'ads_history' => $ads_data
      );
      return view('admin.ads_management.ads_revenue_list',$data);
    }else{
      return abort(404);
    }
  }

  public function save_advertiser_status(Request $request)
  {
    $data = $request->all();
    $id = $data['id'];
    $status = $data['status'];
    $advertiser = Advertiser::find($id);
    $advertiser->status = $status;
    $advertiser->save();
    
    
    return response()->json([ 'success' => true ]);
  }

}

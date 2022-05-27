<?php

namespace App\Http\Controllers;

use App\Advertiser as Advertiser;
use App\Adsurge as Adsurge;
use App\Adscategory as Adscategory;
use App\Setting as Setting;
use App\Adsplan as Adsplan;
use App\Advertisement as Advertisement;
use App\User as User;
use App\Advertiserplanhistory as Advertiserplanhistory;
use \Redirect as Redirect;
use Illuminate\Http\Request;
use DB;
use App\Adviews;
use App\Adrevenue;
use App\Adcampaign;
use View;
use GuzzleHttp\Client;
use GuzzleHttp\Message\Response;
use Carbon\Carbon;
use App\AdsTimeSlot;


class AdminAdvertiserController extends Controller
{
  public function advertisers()
  {
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
    }else{
    $setting = Setting::first();
    // dd($setting);
    if($setting->ads_on_videos == 1){
      $data = array(
        'advertisers' => Advertiser::orderBy('created_at', 'desc')->paginate(9),
      );
      return view('admin.ads_management.advertiser_list',$data);
    }else{
      return abort(404);
    }
  }
  }

  public function advertisersEdit($id)
  {
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
    }else{
    $setting = Setting::first();
    // dd($setting);
    if($setting->ads_on_videos == 1){
      $data = array(
        'advertisers' => Advertiser::where('id',$id)->first(),
      );
      return view('admin.ads_management.advertiser_edit',$data);
    }else{
      return abort(404);
    }
  }
  }
    public function advertisersDelete($id)
    {
      Advertiser::find($id)->delete();
      return Redirect::back();
    }
    public function advertisersUpdate(Request $request)
    {

      $data = $request->all();
      $id = $data['id'];
      $advertisers = Advertiser::find($id);
      $advertisers->company_name = $request->company_name;
      $advertisers->license_number = $request->license_number;
      $advertisers->address = $request->address;
      $advertisers->mobile_number = $request->mobile_number;
      $advertisers->email_id = $request->email_id;

      $advertisers->save();

      return Redirect::back()->with(array('message' => 'Successfully Updated Advertiser Details', 'note_type' => 'success') );
      
      // $setting = Setting::first();
      // // dd($setting);
      // if($setting->ads_on_videos == 1){
      //   $data = array(
      //     'advertisers' => Advertiser::orderBy('created_at', 'desc')->paginate(9),
      //   );
      //   return view('admin.ads_management.advertiser_list',$data);
      // }else{
      //   return abort(404);
      // }
    }

  public function ads_categories()
  {
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
    }else{
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
  }

  public function ads_list()
  {
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
    }else{
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
  }

  public function ads_Edit($id)
  {
    
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
    }else{
    $setting = Setting::first();
    // dd($setting);
    if($setting->ads_on_videos == 1){
      $data = array(
        'advertisement' => Advertisement::where('id',$id)->first(),
        'ads_categories' => Adscategory::get(),
        'advertisers' => Advertiser::get(),
      );
      return view('admin.ads_management.advertisement_edit',$data);
    }else{
      return abort(404);
    }
  }
  }
    public function ads_Delete($id)
    {
      Advertisement::find($id)->delete();
      return Redirect::back();
    }
    public function ads_Update(Request $request)
    {

      $data = $request->all();
      $id = $data['id'];
      $advertisement = Advertisement::find($id);
      $advertisement->advertiser_id = $request->company_name;
      $advertisement->ads_name = $request->ads_name;
      $advertisement->ads_category	 = $request->ads_category	;
      $advertisement->ads_position = $request->ads_position;
      $advertisement->ads_path = $request->ads_path;
      $advertisement->save();

      return Redirect::back()->with(array('message' => 'Successfully Updated Advertisement Details', 'note_type' => 'success') );
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
    }else{
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
    
    return Redirect::back();

    // return response()->json([ 'success' => true ]);
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
    return Redirect::back();

    // return response()->json([ 'success' => true ]);
  }

  public function ads_revenue()
  {
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
    }else{
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

  public function calendarEvent(Request $request)
    {
        if($request->ajax()) {  
            $data = Adsurge::whereDate('start', '>=', $request->start)
                ->whereDate('end',   '<=', $request->end)
                ->get(['id', 'title', 'start', 'end']);
            return response()->json($data);
        }
        return view('admin.ads_management.ad_surge');
    }
 
    public function calendarEventsAjax(Request $request)
    {
 
        switch ($request->type) {
           case 'create':
              $event = Adsurge::create([
                  'title' => $request->title,
                  'start' => $request->start,
                  'end' => $request->end,
              ]);
 
              return response()->json($event);
             break;
  
           case 'edit':
              $event = Adsurge::find($request->id)->update([
                  'title' => $request->title,
                  'start' => $request->start,
                  'end' => $request->end,
              ]);
 
              return response()->json($event);
             break;
  
           case 'delete':
              $event = Adsurge::find($request->id)->delete();
  
              return response()->json($event);
             break;
             
           default:
             # ...
             break;
        }
    }

    public function list_total_cpc() {
      $data = [];
      $data['settings'] = Setting::first();
      
      $data['cpc_lists'] = Adrevenue::orderBy('created_at', 'desc')->paginate(9);
      return view('admin.ads_management.total_cpc',$data);
        
    }

    public function list_total_cpv() {
      $data = [];
      $data['settings'] = Setting::first();
      
      $data['cpv_lists'] = Adviews::orderBy('created_at', 'desc')->paginate(9);
      return view('admin.ads_management.total_cpv',$data);
        
    }

    public function adCampaign(Request $request)
    {
        if($request->ajax()) {  
            $data = Adcampaign::whereDate('start', '>=', $request->start)
                ->whereDate('end',   '<=', $request->end)
                ->get(['id','title','cost','no_of_ads','cpv_advertiser','cpv_admin','start','end']);
            return response()->json($data);
        }
        return view('admin.ads_management.ad_campaign');
    }
 
    public function adCampaignAjax(Request $request)
    {
 
        switch ($request->type) {
           case 'create':
              $event = Adcampaign::create([
                  'title' => $request->title,
                  'cost' => $request->cost,
                  'no_of_ads' => $request->no_of_ads,
                  'cpv_advertiser' => $request->cpv_advertiser,
                  'cpv_admin' => $request->cpv_admin,
                  'start' => $request->start,
                  'end' => $request->end,
              ]);
 
              return response()->json($event);
             break;
  
           case 'edit':
              $event = Adcampaign::find($request->id)->update([
                  'title' => $request->title,
                  'cost' => $request->cost,
                  'start' => $request->start,
                  'end' => $request->end,
              ]);
 
              return response()->json($event);
             break;
  
           case 'delete':
              $event = Adcampaign::find($request->id)->delete();
  
              return response()->json($event);
             break;
             
           default:
             # ...
             break;
        }
    }

    public function AdsTimeSlot()
    {

      $data = [
        'Monday_time'    => AdsTimeSlot::where('day','Monday')->get(),
        'Tuesday_time' =>AdsTimeSlot::where('day','Tuesday')->get(),
        'Wednesday_time' =>AdsTimeSlot::where('day','Wednesday')->get(),
        'Thursday_time' =>AdsTimeSlot::where('day','Thursday')->get(),
        'Friday_time' =>AdsTimeSlot::where('day','Friday')->get(),
        'Saturday_time' =>AdsTimeSlot::where('day','Saturday')->get(),
        'Sunday_time' =>AdsTimeSlot::where('day','Sunday')->get(),
      ];

      return view('admin.ads_management.ads_time_slot',$data);
    }

    public function AdsTimeSlot_Save(Request $request)
    {
      AdsTimeSlot::truncate();

      if($request->Monday_Start_time  != null && $request->Monday_end_time != null ){

        $Monday_start_time = count($request['Monday_Start_time']);

        for ($i=0; $i<$Monday_start_time; $i++){
                $AdsTimeSlot = new AdsTimeSlot;
                $AdsTimeSlot->start_time = $request['Monday_Start_time'][$i];
                $AdsTimeSlot->end_time = $request['Monday_end_time'][$i];
                $AdsTimeSlot->day = "Monday";
                $AdsTimeSlot->save();
        }
      }

      if($request->tuesday_start_time  != null && $request->Tuesday_end_time  != null ){

        $tuesday_start_time = count($request['tuesday_start_time']);

        for ($i=0; $i<$tuesday_start_time; $i++){
                $AdsTimeSlot = new AdsTimeSlot;
                $AdsTimeSlot->start_time = $request['tuesday_start_time'][$i];
                $AdsTimeSlot->end_time = $request['Tuesday_end_time'][$i];
                $AdsTimeSlot->day = "Tuesday";
                $AdsTimeSlot->save();
        }
      }

      if($request->wednesday_start_time  != null && $request->wednesday_end_time  != null ){

        $wednesday_start_time = count($request['wednesday_start_time']);

        for ($i=0; $i<$wednesday_start_time; $i++){
                $AdsTimeSlot = new AdsTimeSlot;
                $AdsTimeSlot->start_time = $request['wednesday_start_time'][$i];
                $AdsTimeSlot->end_time = $request['wednesday_end_time'][$i];
                $AdsTimeSlot->day = "Wednesday";
                $AdsTimeSlot->save();
        }
      }

      if($request->thursday_start_time  != null && $request->thursday_end_time  != null ){

        $thursday_start_time = count($request['thursday_start_time']);

        for ($i=0; $i<$thursday_start_time; $i++){
                $AdsTimeSlot = new AdsTimeSlot;
                $AdsTimeSlot->start_time = $request['thursday_start_time'][$i];
                $AdsTimeSlot->end_time = $request['thursday_end_time'][$i];
                $AdsTimeSlot->day = "Thursday";
                $AdsTimeSlot->save();
        }
      }

      if($request->friday_start_time  != null && $request->friday_end_time  != null){

        $friday_start_time = count($request['friday_start_time']);

        for ($i=0; $i<$friday_start_time; $i++){
                $AdsTimeSlot = new AdsTimeSlot;
                $AdsTimeSlot->start_time = $request['friday_start_time'][$i];
                $AdsTimeSlot->end_time = $request['friday_end_time'][$i];
                $AdsTimeSlot->day = "Friday";
                $AdsTimeSlot->save();
        }
      }

      if($request->saturday_start_time  != null && $request->saturday_end_time  != null  ){

        $saturday_start_time = count($request['saturday_start_time']);

        for ($i=0; $i<$saturday_start_time; $i++){
                $AdsTimeSlot = new AdsTimeSlot;
                $AdsTimeSlot->start_time = $request['saturday_start_time'][$i];
                $AdsTimeSlot->end_time = $request['saturday_end_time'][$i];
                $AdsTimeSlot->day = "Saturday";
                $AdsTimeSlot->save();
        }

      }

      if($request->sunday_start_time  != null && $request->sunday_end_time != null ){

        $sunday_start_time = count($request['sunday_start_time']);

        for ($i=0; $i<$sunday_start_time; $i++){
                $AdsTimeSlot = new AdsTimeSlot;
                $AdsTimeSlot->start_time = $request['sunday_start_time'][$i];
                $AdsTimeSlot->end_time = $request['sunday_end_time'][$i];
                $AdsTimeSlot->day = "Sunday";
                $AdsTimeSlot->save();
        }
      }
     
      return redirect('admin/Ads-TimeSlot');

    }

}

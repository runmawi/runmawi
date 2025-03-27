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
use Illuminate\Support\Str;
use App\Adviews;
use App\Adrevenue;
use App\Adcampaign;
use GuzzleHttp\Client;
use GuzzleHttp\Message\Response;
use Carbon\Carbon;
use App\AdsTimeSlot;
use App\EmailTemplate;
use App\Adsvariables;
use App\AdminAdvertistmentBanners;
use Intervention\Image\Facades\Image;
use Auth;
use Mail;
use URL;
use Hash;
use File;
use View;
use DB;


class AdminAdvertiserController extends Controller
{
    public function advertisers()
    {
        if(!Auth::guest() && Auth::user()->package == 'Channel' ||  Auth::user()->package == 'CPP'){
            return redirect('/admin/restrict');
        }
        $user = User::where('id', 1)->first();
        $duedate = $user->package_ends;
        $current_date = date('Y-m-d');
        if ($current_date > $duedate) {
            $client = new Client();
            $url = 'https://flicknexs.com/userapi/allplans';
            $params = [
                'userid' => 0,
            ];

            $headers = [
                'api-key' => 'k3Hy5qr73QhXrmHLXhpEh6CQ',
            ];
            $response = $client->request('post', $url, [
                'json' => $params,
                'headers' => $headers,
                'verify' => false,
            ]);

            $responseBody = json_decode($response->getBody());
            $settings = Setting::first();
            $data = [
                'settings' => $settings,
                'responseBody' => $responseBody,
            ];
            return View::make('admin.expired_dashboard', $data);
        }else if(check_storage_exist() == 0){
            $settings = Setting::first();

            $data = array(
                'settings' => $settings,
            );

            return View::make('admin.expired_storage', $data);
        } else {
            $setting = Setting::first();
            // dd($setting);
            if ($setting->ads_on_videos == 1) {
                $data = [
                    'advertisers' => Advertiser::orderBy('created_at', 'desc')->paginate(9),
                ];
                return view('admin.ads_management.advertiser_list', $data);
            } else {
                return abort(404);
            }
        }
    }

    public function advertisersEdit($id)
    {
        if(!Auth::guest() && Auth::user()->package == 'Channel' ||  Auth::user()->package == 'CPP'){
            return redirect('/admin/restrict');
        }

        $user = User::where('id', 1)->first();
        $duedate = $user->package_ends;
        $current_date = date('Y-m-d');

        if ($current_date > $duedate) {
            $client = new Client();
            $url = 'https://flicknexs.com/userapi/allplans';
            $params = [  'userid' => 0, ];
            $headers = [   'api-key' => 'k3Hy5qr73QhXrmHLXhpEh6CQ',];

            $response = $client->request('post', $url, [
                'json' => $params,
                'headers' => $headers,
                'verify' => false,
            ]);

            $responseBody = json_decode($response->getBody());
            $settings = Setting::first();
            $data = [
                'settings' => $settings,
                'responseBody' => $responseBody,
            ];
            return View::make('admin.expired_dashboard', $data);
        }else if(check_storage_exist() == 0){
            $settings = Setting::first();

            $data = array(
                'settings' => $settings,
            );

            return View::make('admin.expired_storage', $data);
        } 
        else {
            $setting = Setting::first();
            
            if ($setting->ads_on_videos == 1) {
                $data = [
                    'advertisers' => Advertiser::where('id', $id)->first(),
                ];
                return view('admin.ads_management.advertiser_edit', $data);
            } else {
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
        try {

            $data = $request->all();

            $inputs = array(
                "company_name"   => $request->company_name ,
                "license_number" => $request->license_number ,
                "mobile_number"  => $request->mobile_number ,
                "address"   => $request->address ,
                "email_id"  => $request->email_id ,
                "status"    => $request->status != null || $request->status == "on"  || $request->status == 1  ? 1 : 0 ,
            );

            if( $request->password != null ){
                $inputs+= ["password"  => Hash::make($request->password) ] ;
            }


            Advertiser::find($request->id)->update($inputs);
           
            return Redirect::back()->with(['message' => 'Successfully Updated Advertiser Details', 'note_type' => 'success']);

        } catch (\Throwable $th) {
            // return $th->getMessage();
            return abort(404);
        }
    }

    public function ads_categories()
    {
        if(!Auth::guest() && Auth::user()->package == 'Channel' ||  Auth::user()->package == 'CPP'){
            return redirect('/admin/restrict');
    }
        $user = User::where('id', 1)->first();
        $duedate = $user->package_ends;
        $current_date = date('Y-m-d');
        if ($current_date > $duedate) {
            $client = new Client();
            $url = 'https://flicknexs.com/userapi/allplans';
            $params = [
                'userid' => 0,
            ];

            $headers = [
                'api-key' => 'k3Hy5qr73QhXrmHLXhpEh6CQ',
            ];
            $response = $client->request('post', $url, [
                'json' => $params,
                'headers' => $headers,
                'verify' => false,
            ]);

            $responseBody = json_decode($response->getBody());
            $settings = Setting::first();
            $data = [
                'settings' => $settings,
                'responseBody' => $responseBody,
            ];
            return View::make('admin.expired_dashboard', $data);
        }else if(check_storage_exist() == 0){
            $settings = Setting::first();

            $data = array(
                'settings' => $settings,
            );

            return View::make('admin.expired_storage', $data);
        } else {
            $setting = Setting::first();
            if ($setting->ads_on_videos == 1) {
                $data = [
                    'ads_categories' => Adscategory::orderBy('created_at', 'desc')->paginate(9),
                ];
                return view('admin.ads_management.ads_categories_list', $data);
            } else {
                return abort(404);
            }
        }
    }

    public function ads_list()
    {
        if(!Auth::guest() && Auth::user()->package == 'Channel' ||  Auth::user()->package == 'CPP'){
            return redirect('/admin/restrict');
        }

        $user = User::where('id', 1)->first();
        $duedate = $user->package_ends;
        $current_date = date('Y-m-d');

        if ($current_date > $duedate) {
            $client = new Client();
            $url = 'https://flicknexs.com/userapi/allplans';
            $params = [
                'userid' => 0,
            ];

            $headers = [
                'api-key' => 'k3Hy5qr73QhXrmHLXhpEh6CQ',
            ];
            $response = $client->request('post', $url, [
                'json' => $params,
                'headers' => $headers,
                'verify' => false,
            ]);

            $responseBody = json_decode($response->getBody());
            $settings = Setting::first();
            $data = [
                'settings' => $settings,
                'responseBody' => $responseBody,
            ];
            return View::make('admin.expired_dashboard', $data);
        }else if(check_storage_exist() == 0){
            $settings = Setting::first();

            $data = array(
                'settings' => $settings,
            );

            return View::make('admin.expired_storage', $data);
        } 
        else 
        {
            $setting = Setting::first();
            if ($setting->ads_on_videos == 1) {
                $data = [
                    'advertisements' => Advertisement::orderBy('created_at', 'desc')->paginate(9),
                ];
                return view('admin.ads_management.ads_list', $data);
            } else {
                return abort(404);
            }
        }
    }

    public function ads_Edit($id)
    {
        try {
    
            if(!Auth::guest() && Auth::user()->package == 'Channel' ||  Auth::user()->package == 'CPP'){
                return redirect('/admin/restrict');
            }

            $user = User::where('id', 1)->first();
            $duedate = $user->package_ends;
            $current_date = date('Y-m-d');

            if ($current_date > $duedate) {

                $client = new Client();
                $url = 'https://flicknexs.com/userapi/allplans';
                $params = ['userid' => 0,];

                $headers = [
                    'api-key' => 'k3Hy5qr73QhXrmHLXhpEh6CQ',
                ];
                $response = $client->request('post', $url, [
                    'json' => $params,
                    'headers' => $headers,
                    'verify' => false,
                ]);

                $responseBody = json_decode($response->getBody());
                $settings = Setting::first();
                $data = [
                    'settings' => $settings,
                    'responseBody' => $responseBody,
                ];
                return View::make('admin.expired_dashboard', $data);
            }else if(check_storage_exist() == 0){
                $settings = Setting::first();

                $data = array(
                    'settings' => $settings,
                );

                return View::make('admin.expired_storage', $data);
            } 
            
            else {
                $setting = Setting::first();

                if ($setting->ads_on_videos == 1) {
                    
                    $data = [
                        'advertisement' => Advertisement::where('id', $id)->first(),
                        'ads_categories' => Adscategory::get(),
                        'advertisers' => Advertiser::get(),
                    ];
                    return view('admin.ads_management.advertisement_edit', $data);
                } else {
                    return abort(404);
                }
            }
        } catch (\Throwable $th) {
            return abort(404);
        }
    }

    public function ads_Delete($id)
    {
        Advertisement::find($id)->delete();
        return Redirect::back();
    }

    public function ads_Update(Request $request)
    {
        $inputs = array(
            'ads_name'      => $request->ads_name ,
            'ads_category'  => $request->ads_category ,
            'ads_position'  => $request->ads_position ,
            'ads_upload_type' => $request->ads_upload_type ,
            // 'ads_path' => $request->ads_path ,
            'age' => !empty($request->age) ? json_encode($request->age) : null,
            'gender'   => !empty($request->gender) ? json_encode($request->gender) : null,
            'location' => $request->location === 'all_countries' || $request->location === 'India' ? $request->location : $request->locations,
            'status'   =>  $request->status == "on"  ? 1 : 0 ,
        );

        if ( $request->ads_video != null && $request->ads_upload_type == "ads_video_upload" ) {
         
            $data = array (
                "ads_videos"          => $request->ads_video ,
                "ads_redirection_url" => $request->ads_redirection_url ,
                "advertisement_id"    => $request->id ,
            );

            $Ads_xml_file = $this->Ads_xml_file_update( $data );

            $inputs += array(
                'ads_video' => $Ads_xml_file['Ads_upload_url'] ,
                'ads_path' => $Ads_xml_file['Ads_xml_url'] ,
                'ads_redirection_url' => $request->ads_redirection_url ,
            );

        }

        if ( $request->ads_upload_type == "tag_url" ) {
            $inputs += ['ads_video' => null ];
            $inputs += ['ads_path' => $request->ads_path ];
        }

        Advertisement::where('id', $request->id)->update($inputs);
        
        return Redirect::back()->with(['message' => 'Successfully Updated Advertisement Details', 'note_type' => 'success']);
    }

    private function Ads_xml_file_update( $data )
    {
        
            $Ads_videos = $data["ads_videos"] ;
            $ads_redirection_url = $data["ads_redirection_url"];
            $advertisement_id = $data["advertisement_id"];

            $Advertisement = Advertisement::find($advertisement_id);

            $filename = pathinfo(parse_url($Advertisement->ads_video, PHP_URL_PATH), PATHINFO_FILENAME);

            if (File::exists(base_path('public/uploads/AdsVideos/'. $filename."xml"  ))) {
                File::delete(base_path('public/uploads/AdsVideos/'. $filename."xml"  ));
            }

            if (File::exists(base_path('public/uploads/AdsVideos/'. $filename."mp4"  ))) {
                File::delete(base_path('public/uploads/AdsVideos/'. $filename."mp4"  ));
            }

        
        $Ads_video_slug  =  Str::slug(pathinfo($Ads_videos->getClientOriginalName(), PATHINFO_FILENAME));
        $Ads_video_ext   = $Ads_videos->extension();

        $Ads_xml_filename = time() . '-' . $Ads_video_slug .'.xml';

        $Ads_upload_filename = time() . '-' . $Ads_video_slug .'.'. $Ads_video_ext;
        $Ads_videos->move( public_path('uploads/AdsVideos'), $Ads_upload_filename  );

        $Ads_upload_url = URL::to('public/uploads/AdsVideos/'.$Ads_upload_filename);


        $factory = new \Sokil\Vast\Factory();
        $document = $factory->create('4.1');

        $ad1 = $document
            ->createInLineAdSection()
            ->setId( Str::random(23) )
            ->setAdSystem( $Ads_upload_filename )
            ->setAdTitle(  $Ads_upload_filename );

        $linearCreative = $ad1
            ->createLinearCreative()
            ->setDuration(128)
            ->setId( Str::random(23) );
            // ->setAdId('pre-'.Str::random(23))

            if( $ads_redirection_url != null ){

                $linearCreative->setVideoClicksClickThrough($ads_redirection_url)
                                ->addVideoClicksClickTracking( $ads_redirection_url )
                                ->addVideoClicksCustomClick( $ads_redirection_url );
            }

            // ->addTrackingEvent('start', 'http://ad.server.com/trackingevent/start')
            // ->addTrackingEvent('pause', 'http://ad.server.com/trackingevent/stop');

        $linearCreative
            ->createMediaFile()
            ->setProgressiveDelivery()
            ->setType('video/mp4')
            ->setHeight(200)
            ->setWidth(200)
            ->setBitrate(2500)
            ->setUrl( $Ads_upload_url );

        $domDocument = $document->toDomDocument();
        $xml_file_url = URL::to('public/uploads/AdsVideos/'.$Ads_xml_filename) ;
        $xml_file    = public_path('uploads/AdsVideos/' . $Ads_xml_filename ) ;
        $domDocument->save($xml_file);

        $data = array(
            'Ads_xml_url' => $xml_file_url ,
            'Ads_upload_url' => $Ads_upload_url ,
        );

        return $data ;
    }

    public function save_ads_status(Request $request)
    {
        $data = $request->all();
        $id   = $data['id'];
        $status = $data['status'];

        $Ads = Advertisement::find($id);
        $Ads->status =$status;
        $Ads->save();

        $advertiser_emailid = Advertiser::find($Ads->advertiser_id)->email_id;        $customerName = Advertiser::find($Ads->advertiser_id)->company_name;
        $adminemail   = User::where('role', '=', 'admin')->first()->email;
        $adname       = Advertisement::find($id)->ads_name;
        
        if ($status == 1) {

            try {

                 //Admin Ads Approval
                $email_subject = EmailTemplate::where('id', '=', 42)->pluck('heading')->first();
            
                $settings = Setting::first();
              
                Mail::send('emails.admin_ads_approval', array(

                    'Name' => $customerName,
                    'AdvertiserPortal' => URL::to('/advertiser/login'),
                    'AdvertiserEmail'  => $advertiser_emailid,
                    'AdminEmail'   =>  $adminemail,
                    'website_name' => GetWebsiteName() ,
    
                ) , function ($message) use ($request, $customerName, $adminemail ,$advertiser_emailid , $email_subject, $settings)
                {
                    $message->from(AdminMail() , GetWebsiteName());
                    $message->to($advertiser_emailid, $customerName)->subject($email_subject);
                });

                $email_log      = 'Mail Sent Successfully from Admin Ads Approval E-Mail';
                $email_template = "42";
                $user_id = Auth::user()->id;
    
                Email_sent_log($user_id, $email_log, $email_template);

            } catch (\Throwable $th) {

                $email_log      = $th->getMessage();
                $email_template = "42";
                $user_id =  Auth::user()->id;
            
                Email_notsent_log($user_id, $email_log, $email_template);
            }
        }
        return response()->json(['success' => true]);
    }

    public function ads_plans()
    {
        if(!Auth::guest() && Auth::user()->package == 'Channel' ||  Auth::user()->package == 'CPP'){
            return redirect('/admin/restrict');
    }
        $user = User::where('id', 1)->first();
        $duedate = $user->package_ends;
        $current_date = date('Y-m-d');
        if ($current_date > $duedate) {
            $client = new Client();
            $url = 'https://flicknexs.com/userapi/allplans';
            $params = [
                'userid' => 0,
            ];

            $headers = [
                'api-key' => 'k3Hy5qr73QhXrmHLXhpEh6CQ',
            ];
            $response = $client->request('post', $url, [
                'json' => $params,
                'headers' => $headers,
                'verify' => false,
            ]);

            $responseBody = json_decode($response->getBody());
            $settings = Setting::first();
            $data = [
                'settings' => $settings,
                'responseBody' => $responseBody,
            ];
            return View::make('admin.expired_dashboard', $data);
        }else if(check_storage_exist() == 0){
            $settings = Setting::first();

            $data = array(
                'settings' => $settings,
            );

            return View::make('admin.expired_storage', $data);
        } else {
            $setting = Setting::first();
            if ($setting->ads_on_videos == 1) {
                $data = [
                    'ads_plans' => Adsplan::paginate(9),
                ];
                return view('admin.ads_management.ads_plans_list', $data);
            } else {
                return abort(404);
            }
        }
    }

    public function add_ads_category(Request $request)
    {
        $data = $request->all();
        $Adscategory = new Adscategory();
        $Adscategory->name = $request->name;
        $Adscategory->save();
        return response()->json(['success' => true]);
    }

    public function edit_ads_category(Request $request)
    {
        $data = $request->all();
        $id = $data['id'];
        $Adscategory = Adscategory::find($id);
        $Adscategory->name = $request->name;
        $Adscategory->save();
        return response()->json(['success' => true]);
    }

    public function adscategoryedit($id)
    {
        $Adscategory = Adscategory::find($id);

        return response()->json([
            'data' => $Adscategory,
        ]);
    }

    public function ads_category_delete($id)
    {
        Adscategory::find($id)->delete();

        return Redirect::back();

    }

    public function add_ads_plan(Request $request)
    {
        $data = $request->all();

        Adsplan::create([
           'plan_name'   => $request->plan_name,
           'plan_amount' => $request->plan_amount,
           'no_of_ads'  => $request->no_of_ads,
           'status'     => $request->status ,
           'plan_id'    => $request->plan_id,
           'description' => $request->description,
        ]);
      
        return response()->json(['success' => true]);
    }

    public function edit_ads_plan(Request $request)
    {
        $data = $request->all();

        $id = $data['id'];
        
        $Adsplan = Adsplan::find($id);
        $Adsplan->plan_name   = $request->plan_name;
        $Adsplan->plan_amount = $request->plan_amount;
        $Adsplan->no_of_ads   = $request->no_of_ads;
        $Adsplan->status      = $request->status;
        $Adsplan->plan_id     = $request->plan_id;
        $Adsplan->description = $request->description;
        $Adsplan->save();

        return response()->json(['success' => true]);
    }

    public function adsplanedit($id)
    {
        $Adsplan = Adsplan::find($id);

        return response()->json([
            'data' => $Adsplan,
        ]);
    }

    public function ads_plan_delete($id)
    {
        Adsplan::find($id)->delete();
        return Redirect::back();
    }

    public function ads_revenue()
    {
        if(!Auth::guest() && Auth::user()->package == 'Channel' ||  Auth::user()->package == 'CPP'){
            return redirect('/admin/restrict');
    }
        $user = User::where('id', 1)->first();
        $duedate = $user->package_ends;
        $current_date = date('Y-m-d');
        if ($current_date > $duedate) {
            $client = new Client();
            $url = 'https://flicknexs.com/userapi/allplans';
            $params = [
                'userid' => 0,
            ];

            $headers = [
                'api-key' => 'k3Hy5qr73QhXrmHLXhpEh6CQ',
            ];
            $response = $client->request('post', $url, [
                'json' => $params,
                'headers' => $headers,
                'verify' => false,
            ]);

            $responseBody = json_decode($response->getBody());
            $settings = Setting::first();
            $data = [
                'settings' => $settings,
                'responseBody' => $responseBody,
            ];
            return View::make('admin.expired_dashboard', $data);
        }else if(check_storage_exist() == 0){
            $settings = Setting::first();

            $data = array(
                'settings' => $settings,
            );

            return View::make('admin.expired_storage', $data);
        } else {
            $setting = Setting::first();
            if ($setting->ads_on_videos == 1) {
                // $ads_data = DB::table('advertiser_plan_history')
                // ->join('advertisers', 'advertiser_plan_history.advertiser_id', '=', 'advertisers.id')
                // ->join('ads_plans', 'advertiser_plan_history.plan_id', '=', 'ads_plans.id')
                // ->select('advertiser_plan_history.*', 'advertisers.company_name', 'ads_plans.plan_amount', 'ads_plans.plan_name')
                // ->get();

                $ads_data = Advertiserplanhistory::join('advertisers', 'advertiser_plan_history.advertiser_id', '=', 'advertisers.id')
                    ->join('ads_plans', 'advertiser_plan_history.plan_id', '=', 'ads_plans.id')
                    ->select('advertiser_plan_history.*', 'advertisers.company_name', 'ads_plans.plan_amount', 'ads_plans.plan_name')
                    ->get();

                $data = [
                    'ads_history' => $ads_data,
                ];
                return view('admin.ads_management.ads_revenue_list', $data);
            } else {
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

        return response()->json(['success' => true]);
    }

    public function calendarEvent(Request $request)
    {
        if ($request->ajax()) {
            $data = Adsurge::whereDate('start', '>=', $request->start)
                ->whereDate('end', '<=', $request->end)
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

    public function list_total_cpc()
    {
        $data = [];
        $data['settings'] = Setting::first();

        $data['cpc_lists'] = Adrevenue::orderBy('created_at', 'desc')->paginate(9);
        return view('admin.ads_management.total_cpc', $data);
    }

    public function list_total_cpv()
    {
        $data = [];
        $data['settings'] = Setting::first();

        $data['cpv_lists'] = Adviews::orderBy('created_at', 'desc')->paginate(9);
        return view('admin.ads_management.total_cpv', $data);
    }

    public function adCampaign(Request $request)
    {
        if ($request->ajax()) {
            $data = Adcampaign::whereDate('start', '>=', $request->start)
                ->whereDate('end', '<=', $request->end)
                ->get(['id', 'title', 'cost', 'no_of_ads', 'cpv_advertiser', 'cpv_admin', 'start', 'end']);
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
            'Monday_time' => AdsTimeSlot::where('day', 'Monday')->get(),
            'Tuesday_time' => AdsTimeSlot::where('day', 'Tuesday')->get(),
            'Wednesday_time' => AdsTimeSlot::where('day', 'Wednesday')->get(),
            'Thursday_time' => AdsTimeSlot::where('day', 'Thrusday')->get(),
            'Friday_time' => AdsTimeSlot::where('day', 'Friday')->get(),
            'Saturday_time' => AdsTimeSlot::where('day', 'Saturday')->get(),
            'Sunday_time' => AdsTimeSlot::where('day', 'Sunday')->get(),
        ];

        return view('admin.ads_management.ads_time_slot', $data);
    }

    public function AdsTimeSlot_Save(Request $request)
    {
        AdsTimeSlot::truncate();

        if ($request->Monday_Start_time != null && $request->Monday_end_time != null) {
            $Monday_start_time = count($request['Monday_Start_time']);

            for ($i = 0; $i < $Monday_start_time; $i++) {
                $AdsTimeSlot = new AdsTimeSlot();
                $AdsTimeSlot->start_time = $request['Monday_Start_time'][$i];
                $AdsTimeSlot->end_time = $request['Monday_end_time'][$i];
                $AdsTimeSlot->day = 'Monday';
                $AdsTimeSlot->save();
            }
        }

        if ($request->tuesday_start_time != null && $request->Tuesday_end_time != null) {
            $tuesday_start_time = count($request['tuesday_start_time']);

            for ($i = 0; $i < $tuesday_start_time; $i++) {
                $AdsTimeSlot = new AdsTimeSlot();
                $AdsTimeSlot->start_time = $request['tuesday_start_time'][$i];
                $AdsTimeSlot->end_time = $request['Tuesday_end_time'][$i];
                $AdsTimeSlot->day = 'Tuesday';
                $AdsTimeSlot->save();
            }
        }

        if ($request->wednesday_start_time != null && $request->wednesday_end_time != null) {
            $wednesday_start_time = count($request['wednesday_start_time']);

            for ($i = 0; $i < $wednesday_start_time; $i++) {
                $AdsTimeSlot = new AdsTimeSlot();
                $AdsTimeSlot->start_time = $request['wednesday_start_time'][$i];
                $AdsTimeSlot->end_time = $request['wednesday_end_time'][$i];
                $AdsTimeSlot->day = 'Wednesday';
                $AdsTimeSlot->save();
            }
        }

        if ($request->thursday_start_time != null && $request->thursday_end_time != null) {
            $thursday_start_time = count($request['thursday_start_time']);

            for ($i = 0; $i < $thursday_start_time; $i++) {
                $AdsTimeSlot = new AdsTimeSlot();
                $AdsTimeSlot->start_time = $request['thursday_start_time'][$i];
                $AdsTimeSlot->end_time = $request['thursday_end_time'][$i];
                $AdsTimeSlot->day = 'Thursday';
                $AdsTimeSlot->save();
            }
        }

        if ($request->friday_start_time != null && $request->friday_end_time != null) {
            $friday_start_time = count($request['friday_start_time']);

            for ($i = 0; $i < $friday_start_time; $i++) {
                $AdsTimeSlot = new AdsTimeSlot();
                $AdsTimeSlot->start_time = $request['friday_start_time'][$i];
                $AdsTimeSlot->end_time = $request['friday_end_time'][$i];
                $AdsTimeSlot->day = 'Friday';
                $AdsTimeSlot->save();
            }
        }

        if ($request->saturday_start_time != null && $request->saturday_end_time != null) {
            $saturday_start_time = count($request['saturday_start_time']);

            for ($i = 0; $i < $saturday_start_time; $i++) {
                $AdsTimeSlot = new AdsTimeSlot();
                $AdsTimeSlot->start_time = $request['saturday_start_time'][$i];
                $AdsTimeSlot->end_time = $request['saturday_end_time'][$i];
                $AdsTimeSlot->day = 'Saturday';
                $AdsTimeSlot->save();
            }
        }

        if ($request->sunday_start_time != null && $request->sunday_end_time != null) {
            $sunday_start_time = count($request['sunday_start_time']);

            for ($i = 0; $i < $sunday_start_time; $i++) {
                $AdsTimeSlot = new AdsTimeSlot();
                $AdsTimeSlot->start_time = $request['sunday_start_time'][$i];
                $AdsTimeSlot->end_time = $request['sunday_end_time'][$i];
                $AdsTimeSlot->day = 'Sunday';
                $AdsTimeSlot->save();
            }
        }

        return redirect('admin/Ads-TimeSlot');
    }

    public function ads_viewcount(Request $request)
    {
        try {
            Adviews::create([
                'video_id' => $request->video_id,
                'ad_id' => $request->ads_id,
                'advertiser_id' => $request->advertiser_id,
                'views_count' => 1,
            ]);
            return 'success';
        } catch (\Exception $e) {
            return 'false';
        }
    }

    public function ads_viewcount_mid(Request $request)
    {
        try {
            Adviews::create([
                'video_id' => $request->video_id,
                'ad_id' => $request->ads_id,
                'advertiser_id' => $request->advertiser_id,
                'views_count' => 1,
            ]);
            return 'success';
        } catch (\Exception $e) {
            return 'false';
        }
    }

    public function ads_viewcount_Post(Request $request)
    {
        try {
            Adviews::create([
                'video_id' => $request->video_id,
                'ad_id' => $request->ads_id,
                'advertiser_id' => $request->advertiser_id,
                'views_count' => 1,
            ]);
            return 'success';
        } catch (\Exception $e) {
            return 'false';
        }
    }

    public function ads_banners(Request $request)
    {
        try {
         
            $data = [
                'ads_banners' => AdminAdvertistmentBanners::first(),
            ];

            return view('admin.ads_management.ads_banners',$data);
            
        } catch (\Throwable $th) {
            
            return abort(404);
        }
    }

    public function ads_banners_update(Request $request)
    {
        try {

            $inputs = array(
                'left_ads_banners_type'  => $request->left_ads_banners_type ,
                'left_script_url'        => $request->left_ads_banners_type == "left_script_url" ? $request->left_script_url : null,
                
                'right_ads_banners_type'  => $request->right_ads_banners_type ,
                'right_script_url'        => $request->right_ads_banners_type == "right_script_url" ? $request->right_script_url : null ,

                'bottom_ads_banners_type' => $request->bottom_ads_banners_type ,
                'bottom_script_url'       => $request->bottom_ads_banners_type == "bottom_script_url" ? $request->bottom_script_url : null ,
                
                'top_ads_banners_type'    => $request->top_ads_banners_type ,
                'top_script_url'          => $request->top_ads_banners_type == "top_script_url" ? $request->top_script_url : null ,
                
                'right_banner_status'     => !empty($request->right_banner_status) || $request->right_banner_status == "on" ? 1 : 0  ,
                'left_banner_status'      => !empty($request->left_banner_status) || $request->left_banner_status == "on" ? 1 : 0  ,
                'top_banner_status'       => !empty($request->top_banner_status) || $request->top_banner_status == "on" ? 1 : 0  ,
                'bottom_banner_status'    => !empty($request->bottom_banner_status) || $request->bottom_banner_status == "on" ? 1 : 0  ,
            );

            if( $request->left_ads_banners_type == "left_script_url" ){

                $inputs += ['left_image_url' =>  null ];
            }
            
            if( $request->right_ads_banners_type == "right_script_url" ){

                $inputs += ['right_image_url' =>  null ];
            }
            
            if( $request->bottom_ads_banners_type == "bottom_script_url" ){

                $inputs += ['bottom_image_url' =>  null ];
            }
            
            if( $request->top_ads_banners_type == "top_script_url" ){

                $inputs += ['top_image_url' =>  null ];
            }

            if($request->hasFile('left_image_url')){

                $file = $request->left_image_url;

                if(compress_image_enable() == 1){

                    $filename   = 'Ads-banners-image-'.time().'.'. compress_image_format();
                    Image::make($file)->save(base_path().'/public/uploads/Ads-banners/'.$filename , compress_image_resolution() );

                }else{

                    $filename   = 'Ads-banners-image-'.time().'.'.$file->getClientOriginalExtension();
                    Image::make($file)->save(base_path().'/public/uploads/Ads-banners/'.$filename );
                }

                $inputs+=['left_image_url' =>  URL::to('public/uploads/Ads-banners/'.$filename) ];
            }

            if($request->hasFile('right_image_url')){

                $file = $request->right_image_url;

                if(compress_image_enable() == 1){

                    $filename   = 'Ads-banners-image-'.time().'.'. compress_image_format();
                    Image::make($file)->save(base_path().'/public/uploads/Ads-banners/'.$filename , compress_image_resolution() );

                }else{

                    $filename   = 'Ads-banners-image-'.time().'.'.$file->getClientOriginalExtension();
                    Image::make($file)->save(base_path().'/public/uploads/Ads-banners/'.$filename );
                }

                $inputs+=['right_image_url' => URL::to('public/uploads/Ads-banners/'.$filename) ];
            }

            if($request->hasFile('top_image_url')){

                $file = $request->top_image_url;

                if(compress_image_enable() == 1){

                    $filename   = 'Ads-banners-image-'.time().'.'. compress_image_format();
                    Image::make($file)->save(base_path().'/public/uploads/Ads-banners/'.$filename , compress_image_resolution() );

                }else{

                    $filename   = 'Ads-banners-image-'.time().'.'.$file->getClientOriginalExtension();
                    Image::make($file)->save(base_path().'/public/uploads/Ads-banners/'.$filename );
                }

                $inputs +=  ['top_image_url' => URL::to('public/uploads/Ads-banners/'.$filename) ];
            }
            
            if($request->hasFile('bottom_image_url')){

                $file = $request->bottom_image_url;

                if(compress_image_enable() == 1){

                    $filename   = 'Ads-banners-image-'.time().'.'. compress_image_format();
                    Image::make($file)->save(base_path().'/public/uploads/Ads-banners/'.$filename , compress_image_resolution() );

                }else{

                    $filename   = 'Ads-banners-image-'.time().'.'.$file->getClientOriginalExtension();
                    Image::make($file)->save(base_path().'/public/uploads/Ads-banners/'.$filename );
                }

                $inputs +=  ['bottom_image_url' => URL::to('public/uploads/Ads-banners/'.$filename) ];
            }

            AdminAdvertistmentBanners::first() == null ? AdminAdvertistmentBanners::create($inputs) : AdminAdvertistmentBanners::first()->update($inputs); 

            return redirect(route('admin.ads_banners'));

        } catch (\Throwable $th) {

            return abort(404);
        }
    }

    public function ads_variable(){

        if(!Auth::guest() && Auth::user()->package == 'Channel' ||  Auth::user()->package == 'CPP'){
            return redirect('/admin/restrict');
        }

        $user = User::where('id', 1)->first();
        $duedate = $user->package_ends;
        $current_date = date('Y-m-d');

        if ($current_date > $duedate) {
            $client = new Client();
            $url = 'https://flicknexs.com/userapi/allplans';
            $params = [
                'userid' => 0,
            ];

            $headers = [
                'api-key' => 'k3Hy5qr73QhXrmHLXhpEh6CQ',
            ];
            $response = $client->request('post', $url, [
                'json' => $params,
                'headers' => $headers,
                'verify' => false,
            ]);

            $responseBody = json_decode($response->getBody());
            $settings = Setting::first();
            $data = [
                'settings' => $settings,
                'responseBody' => $responseBody,
            ];
            return View::make('admin.expired_dashboard', $data);
        }else if(check_storage_exist() == 0){
            $settings = Setting::first();

            $data = array(
                'settings' => $settings,
            );

            return View::make('admin.expired_storage', $data);
        } else {
            try {

                $data = [
                    'ads_variables' => Adsvariables::paginate(15),
                ];
    
                return view('admin.ads_management.Ads_variables',$data);

            } catch (\Throwable $th) {
                return $th->getMessage();
                return abort(404);
            }
        }
    }

    public function ads_variables_store(Request $request){

        if(!Auth::guest() && Auth::user()->package == 'Channel' ||  Auth::user()->package == 'CPP'){
            return redirect('/admin/restrict');
        }

        $user = User::where('id', 1)->first();
        $duedate = $user->package_ends;
        $current_date = date('Y-m-d');

        if ($current_date > $duedate) {
            $client = new Client();
            $url = 'https://flicknexs.com/userapi/allplans';
            $params = [
                'userid' => 0,
            ];

            $headers = [
                'api-key' => 'k3Hy5qr73QhXrmHLXhpEh6CQ',
            ];
            $response = $client->request('post', $url, [
                'json' => $params,
                'headers' => $headers,
                'verify' => false,
            ]);

            $responseBody = json_decode($response->getBody());
            $settings = Setting::first();
            $data = [
                'settings' => $settings,
                'responseBody' => $responseBody,
            ];
            return View::make('admin.expired_dashboard', $data);
        }else if(check_storage_exist() == 0){
            $settings = Setting::first();

            $data = array(
                'settings' => $settings,
            );

            return View::make('admin.expired_storage', $data);
        } else {
            try {

                $data = array(
                    "name" => $request->name,
                    "website" => $request->website,
                    "andriod" => $request->andriod,
                    "ios" => $request->ios,
                    "tv" => $request->tv,
                    "roku" => $request->roku,
                    "Lg" => $request->Lg,
                    "samsung" => $request->samsung,
                    "firetv" => $request->firetv,
                );

                Adsvariables::create($data);

                return response()->json(['success' => true]);

            } catch (\Throwable $th) {
                return abort(404);
            }
        }
    }

    public function ads_variables_edit($id)
    {
        $Adsvariables = Adsvariables::find($id);

        return response()->json([
            'data' => $Adsvariables,
        ]);
    }

    public function ads_variables_update(Request $request,$id)
    {

        $data = array(
            "name" => $request->name,
            "website" => $request->website,
            "andriod" => $request->andriod,
            "ios" => $request->ios,
            "tv" => $request->tv,
            "roku" => $request->roku,
            "Lg" => $request->Lg,
            "samsung" => $request->samsung,
            "firetv" => $request->firetv,
        );

        $Adsvariables = Adsvariables::find($id)->update($data);

        return response()->json(['success' => true]);
    }

    public function ads_variables_delete($id)
    {
        Adsvariables::destroy($id);

        return redirect()->route('admin.ads_variable');

    }

    public function ads_change_url(){
    
        $adsvariables = Adsvariables::get();

        $baseUrl = 'https://7529ea7ef7344952b6acc12ff243ed43.mediatailor.us-west-2.amazonaws.com/v1/master/2d2d0d97b0e548f025b2598a69b55bf30337aa0e/npp_795/07VF419BOTBBVEGLG5ZA/hls3/now,-1m/m.m3u8?ads.app_bundle=[appBundle]&ads.app_name=[appName]&ads.app_platform=[OPERATING_SYSTEM]&ads.app_store_url=[AppStoreUrl]&ads.app_ver=[OPERATING_SYSTEM_VERSION]&ads.channel_name=FiredUp+Network&ads.content_cat=IAB17&ads.content';

        foreach ($adsvariables as $adsvariable) {
        $name = $adsvariable->name;
        $website = $adsvariable->website;

        $baseUrl = str_replace("[$name]", $website, $baseUrl);
        }

        return $baseUrl;

    }

}
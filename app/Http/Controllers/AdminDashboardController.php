<?php

namespace App\Http\Controllers;

use \App\User as User;
use \App\Setting as Setting;
use \App\Video as Video;
use \App\VideoCategory as VideoCategory;
use \App\PpvVideo as PpvVideo;
use \App\Subscription as Subscription;
use \Redirect as Redirect;
use Illuminate\Http\Request;
use App\RecentView as RecentView;
use URL;
use Carbon\Carbon as Carbon;
use Auth;
use Hash;
use Illuminate\Support\Facades\Cache;
use Image;
use View;
use App\CategoryVideo as CategoryVideo;
use App\LanguageVideo;
use App\Episode;
use App\LiveStream;
use App\Audio;
use GuzzleHttp\Client;
use GuzzleHttp\Message\Response;
use Mail;
use Laravel\Cashier\Invoice;
use App\StorageSetting;
use App\PpvPurchase;
use App\Language;
use App\LoggedDevice;
use App\GuestLoggedDevice;
use GuzzleHttp\Exception\RequestException;
use League\Flysystem\Filesystem;
use PlatformCommunity\Flysystem\BunnyCDN\BunnyCDNAdapter;
use PlatformCommunity\Flysystem\BunnyCDN\BunnyCDNClient;
use PlatformCommunity\Flysystem\BunnyCDN\BunnyCDNRegion;
use Illuminate\Support\Facades\Storage;

class AdminDashboardController extends Controller
{


    public function __construct() 
    {
        $storageZoneRegion = 'LA';
        $this->storageZoneName = 'filestoragelaravel';
        $this->apiAccessKey = '26a367c4-353f-4030-bb3a-6d91a90eaa714281b472-2fee-4454-990c-afe871f94c73';
        $this->storageZoneRegion = strtolower($storageZoneRegion);
    }

    public function Index()
    {
        if(!Auth::guest() && Auth::user()->package == 'Channel' ||  Auth::user()->package == 'CPP'){
                return redirect('/admin/restrict');
        }
           if (!Auth::user()->role == 'admin')
            {
                return redirect('/home');
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
            
                $StorageSetting = StorageSetting::first();
                if(!empty($StorageSetting->site_key && $StorageSetting->site_user && $StorageSetting->site_action)){
                $data = array('key' => $StorageSetting->site_key,
                'action' => $StorageSetting->site_action,
                'user'=> $StorageSetting->site_user);

                    // $data = array(
                    //     "key" => "ymR5pBF7IDZkPshdU4Vrl36AO0VtHxiwgQPxqtcbqIFumE6qfKx2P6e4UXc40kkxA7BHGy",
                    //     "action" => "list",
                    //     "user" => "jacksmac"
                    // );
                    
                    $url = "https://$StorageSetting->site_IPSERVERAPI/v1/accountdetail";
                    
                    $ch = curl_init($url);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

                    $response = curl_exec($ch);
                    $storage = json_decode($response);
                    // dd($storage);
                    if (curl_errno($ch)) {
                        $space_available = 0 .' '.'TB';
                        $space_usage = 0 .' '.'TB';
                        $space_disk = 0 .' '.'TB';
                    } else {

                        $spaceavailable = ($storage->result->account_info->space_available ) ;
                        $spaceusage = $storage->result->account_info->space_usage  ;
                        $spacedisk = $storage->result->account_info->space_disk  ;

                        if($spaceavailable == 'unlimited'){
                            $space_available = 'unlimited';
                        }else{
                            $space_available = intval(round($spaceavailable  / 1024 ,3)).' '.'GB';
                        }

                        $space_usage = intval(round($spaceusage  / 1024 ,3)).' '.'GB';	
                        $space_disk = intval(round($spacedisk  / 1024 ,3)).' '.'GB';	

                        // dd(intval($fileSize));

                        // $spaceavailable = $space_available * 1024; // space_available Convert TB to GB
                        // $space_available = round($spaceavailable).' '.'GB';
                        // $spaceusage = $space_usage * 1024; // space_usage Convert TB to GB
                        // $space_usage = round($spaceusage).' '.'GB';
                        // $spacedisk = $space_disk * 1024; // space_disk Convert TB to GB
                        // $space_disk = round($spacedisk).' '.'GB';

                        if($space_available == "0 GB"){
                            $value = $storage->result->account_info->space_available / 1024;
                            $space_available = round($value / 0.001, 2).' '.'GB'; // Round to 2 decimal places
                        }
                        if($space_usage == "0 GB"){
                            $value = $storage->result->account_info->space_usage / 1024;
                            $space_usage =  round($value / 0.001, 2).' '.'GB'; // Round to 2 decimal places

                        }
                        if($space_disk == "0 GB"){
                            $value = $storage->result->account_info->space_disk / 1024;
                            $space_disk = round($value / 0.001, 2).' '.'GB'; // Round to 2 decimal places
                        }
                    }
                    curl_close($ch);

                }else{
                    $space_available = 0 .' '.'TB';
                    $space_usage = 0 .' '.'TB';
                    $space_disk = 0 .' '.'TB';
                }
 
        $videocategory = VideoCategory::get();
        $categoryvideo = CategoryVideo::get();
        if(count($videocategory) > 0){
        foreach($videocategory as $key => $category){
            // $video_category['name_category'] = $category->name;
            $video_category[$category->name] = CategoryVideo::where('category_id','=',$category->id)->count();
            // $video_category[$category->name] = Video::where('video_category_id','=',$category->id)->count();
        }
    }else{
        $video_category = [];
    }
        $recomendeds = Video::select('videos.*','video_categories.name as categories_name','categoryvideos.category_id as categories_id')
        ->Join('categoryvideos', 'videos.id', '=', 'categoryvideos.video_id')
        ->Join('video_categories', 'categoryvideos.category_id', '=', 'video_categories.id')
        // ->where('videos.id','!=',$vid)
        ->limit(10)->get();
        

         $settings = Setting::first();
        
         $total_subscription = Subscription::where('stripe_status','=','active')->count();
        
         $total_videos = Video::where('active','=',1)->count();
        
         $total_ppvvideos = PpvVideo::where('active','=',1)->count();
         
        $total_recent_subscription = Subscription::orderBy('created_at', 'DESC')->whereDate('created_at', '>', \Carbon\Carbon::now()->today())->count();
        $top_rated_videos = Video::where("rating",">",7)->get();
        $recent_views = RecentView::limit(10)->orderBy('id','DESC')->get();
        $recent_view = $recent_views->unique('video_id');
        $page = 'admin-dashboard';
        
        $total_users = User::count();
        $Total_Subscribers = User::where('role','subscriber')->count();

        $Total_PPV_Revenue = PpvPurchase::sum('total_amount');
        $Total_Subscription_Revenue = Subscription::sum('price');
        $Total_Revenue = $Total_PPV_Revenue + $Total_Subscription_Revenue;

        $Month_PPV_Revenue = PpvPurchase::whereMonth('created_at', Carbon::now()->month)->sum('total_amount');
        $Month_Subscription_Revenue = Subscription::whereMonth('created_at', Carbon::now()->month)->sum('price');
        $Total_Monthly_Revenue = $Month_PPV_Revenue + $Month_Subscription_Revenue;

        $VideoCategory = VideoCategory::get();
        $Language = Language::get();

        $LoggedDevice = LoggedDevice::count(); 
        $GuestLoggedDevice = GuestLoggedDevice::count();
        $total_visitors = $LoggedDevice + $GuestLoggedDevice ;
        // dd($total_visitors);
        $data = array(
                'settings' => $settings,
                'total_subscription' => $total_subscription,
                'total_recent_subscription' => $total_recent_subscription,
                'total_videos' => $total_videos,
                'top_rated_videos' => $top_rated_videos,
                'recent_views' => $recent_view,
                'page' => $page,
                'total_ppvvideos' => $total_ppvvideos,
                'video_category' => $video_category,
                'space_available' => $space_available,
                'space_usage' => $space_usage,
                'space_disk' => ($space_disk),
                'settings' => $settings,
                'total_users' => $total_users,
                'Total_Subscribers' => $Total_Subscribers,
                'Total_Monthly_Revenue' => $Total_Monthly_Revenue,
                'VideoCategory' => $VideoCategory,
                'Language' => $Language,
                'total_visitors' => $total_visitors,

        );
        
		return View::make('admin.dashboard', $data);
    }
        
    }

    public function Masterlist()

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
        }
        else{
                $Videos =  Video::orderBy('created_at', 'DESC')->get();

                $LiveStream = LiveStream::orderBy('created_at', 'DESC')->get();

                $audios = Audio::orderBy('created_at', 'DESC')->get();

                $Episode = Episode::Select('episodes.*','series.title as series_title')->leftjoin('series', 'series.id', '=', 'episodes.series_id')
                            ->orderBy('created_at', 'DESC')->get();

                $master_count = count($LiveStream) + count($audios) + count($Episode) + count($Videos);

                $data = array(
                    'Videos' => $Videos,
                    'LiveStream' => $LiveStream,
                    'audios'  => $audios,
                    'Episode' => $Episode,
                    'master_count' => $master_count,
                );

                return View::make('admin.Masterlist.index', $data);
            }
    }

    public function PlanPurchase($plan_name)
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
        if($plan_name == "Basic"){
            $plandata = $responseBody->plandata[0];
        }elseif($plan_name == "Pro"){
            $plandata = $responseBody->plandata[1];

        }elseif($plan_name == "Business"){
            $plandata = $responseBody->plandata[2];

        }else{
            $plandata = " ";
        }
        // dd($plandata);
        return redirect('/admin/flicknexs');
    }
    public function AdminFlicknexs()
    {
        $url = "https://flicknexs.com/login";
        // dd($url);
        return Redirect::intended($url);
        return redirect()->away('https://flicknexs.com/login');

    }
    public function AdminFlicknexsMonthly($plan_slug)
    {

        $url = "https://flicknexs.com/upgrade/".$plan_slug;
        return Redirect::intended($url);

    }
    public function AdminFlicknexsYearly($plan_slug)
    {

        $url = "https://flicknexs.com/upgrade/".$plan_slug.'/yearly';
        return Redirect::intended($url);

    }

    public function ActiveSlider(Request $request){

     
        $Active_Videos =  Video::where('banner',1)->orderBy('created_at', 'DESC')->get();

        $Active_LiveStream = LiveStream::where('banner',1)->orderBy('created_at', 'DESC')->get();

        $Active_Episode = Episode::Select('episodes.*','series.title as series_title')->leftjoin('series', 'series.id', '=', 'episodes.series_id')
                            ->where('episodes.banner',1)->orderBy('created_at', 'DESC')->get();

        $Active_count = count($Active_Videos) +  count($Active_LiveStream) + count($Active_Episode);

        $data = array(
            'Videos' => $Active_Videos,
            'LiveStream' => $Active_LiveStream,
            'Episode' => $Active_Episode,
            'Active_count' => $Active_count,
            );

         return View::make('admin.videos.Active_slider', $data);

    }

    public function ActiveSlider_update(Request $request)
    {
       
        try {
            if($request->type == "video"){
                $video = Video::where('id',$request->video_id)->update([
                    'banner' => $request->banner_status,
                ]);
            }
            elseif($request->type == "Livestream"){
                $LiveStream = LiveStream::where('id',$request->video_id)->update([
                    'banner' => $request->banner_status,
                ]);

            }elseif($request->type == "Episode"){
                $Episode = Episode::where('id',$request->video_id)->update([
                    'banner' => $request->banner_status,
                ]);
            }

            return response()->json(['message'=>"true"]);

        } catch (\Throwable $th) {
            return response()->json(['message'=>"false"]);
        }
    
    }
    public function testuserroute(){
        $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
        $userIp = $geoip->getip();
        $countryName = $geoip->getCountry();
        $regionName = $geoip->getregion();
        $cityName = $geoip->getcity();
        $userIp = '64.179.166.46';
        $userIp = $geoip->setIP('64.179.166.46');
        $locationData = \Location::get($userIp);
        // echo"<pre>";
        // print_r($locationData);
        // echo"<pre>";
        // print_r($countryName);$geoip->getCountry()
        // echo"<pre>";
        // print_r($regionName);$geoip->getRegion()
        // echo"<pre>";
        // print_r($cityName);$geoip->getCity()
        // exit;
    }

    public function TranslateLanguage(Request $request){

        try {

            $Setting = Setting::first();
            Setting::first()
            ->update([
                    'translate_language'  => $request->languageCode ,
                  ]);

                  $Setting = Setting::first();
                  $Setting->translate_language = $request->languageCode;
                  $Setting->save();

                  return 1 ;

        } catch (\Throwable $th) {
            throw $th;
        }
       
    }
        public function AdminTranslateLanguage(Request $request){

            try {
    
                $Setting = Setting::first();
                Setting::first()
                ->update([
                        'translate_language'  => $request->languageCode ,
                      ]);
    
                      $Setting = Setting::first();
                      $Setting->admin_translate_language = $request->languageCode;
                      $Setting->save();
    
                      return 1 ;
    
            } catch (\Throwable $th) {
                throw $th;
            }
           
        }
    
        private function getBaseUrl()
        {
            if($this->storageZoneRegion == "la" || $this->storageZoneRegion == "")
            {
                return "https://storage.bunnycdn.com/";
            }
            else
            {
                return "https://{$this->storageZoneRegion}.storage.bunnycdn.com/";
            }
        }

        public function BunnyCDNUpload(Request $request){

            try {

                
                // Your BunnyCDN API Key
                $apiKey = '26a367c4-353f-4030-bb3a-6d91a90eaa714281b472-2fee-4454-990c-afe871f94c73';
                
                // Your Storage Zone Name
                $storageZone = 'filestoragelaravel';
                
                // Local path to the video file you want to upload
                $uploadFile = 'http://localhost/flicknexs/storage/app/public/6gEf874vRWsMyTSp.mp4';
                
                // File name to use on BunnyCDN (change if needed)
                $remoteFileName = 'video.mp4';
                
                // $apiKey = 'your_bunnycdn_api_key';
                // $storageZone = 'your_storage_zone';

                // $client = new Client();

                // $response = $client->request('GET', 'https://api.bunny.net/storagezone/438031', [
                //     'headers' => [
                //       'AccessKey' => '26a367c4-353f-4030-bb3a-6d91a90eaa714281b472-2fee-4454-990c-afe871f94c73',
                //       'accept' => 'application/json',
                //     ],
                //   ]);
                  
                //   echo $response->getBody();

                $REGION = 'la';
                $HOSTNAME = 'la.storage.bunnycdn.com';
                $STORAGE_ZONE_NAME = 'filestoragelaravel';  
                $ACCESS_KEY = '2b2e513c-c6e9-4ffe-8d8a24b8f1f6-9b68-4434';  // Replace with your actual access key
                
                $url = "{$HOSTNAME}/{$STORAGE_ZONE_NAME}/";
                
                $ch = curl_init();
                
                $options = array(
                    CURLOPT_URL => $url,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_HTTPHEADER => array(
                        "AccessKey: '2b2e513c-c6e9-4ffe-8d8a24b8f1f6-9b68-4434'",
                        'Content-Type: application/json',
                    ),
                );
                
                curl_setopt_array($ch, $options);
                
                $response = curl_exec($ch);
                
                if (!$response) {
                    die("Error: " . curl_error($ch));
                } else {
                    $decodedResponse = json_decode($response, true);
                
                    if ($decodedResponse === null) {
                        die("Error decoding JSON response: " . json_last_error_msg());
                    }
                
                    // Process $decodedResponse as needed, it contains information about the files in the storage zone
                    print_r($decodedResponse);
                }
                
                curl_close($ch);
                exit;
                $data = json_decode($response->getBody(), true);
                return $data;
                
            } catch (\Throwable $th) {
                throw $th;
            }
           
        }
}

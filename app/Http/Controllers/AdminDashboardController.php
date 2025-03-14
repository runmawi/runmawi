<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use GuzzleHttp\Exception\RequestException;
use League\Flysystem\Filesystem;
use PlatformCommunity\Flysystem\BunnyCDN\BunnyCDNAdapter;
use PlatformCommunity\Flysystem\BunnyCDN\BunnyCDNClient;
use PlatformCommunity\Flysystem\BunnyCDN\BunnyCDNRegion;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\JsonResponse;
use Mail;
use URL;
use Auth;
use Hash;
use Image;
use View;
use Session;
use Carbon\Carbon as Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Message\Response;
use Laravel\Cashier\Invoice;
use \App\User ;
use \App\Setting ;
use \App\Video ;
use \App\VideoCategory ;
use \App\PpvVideo ;
use \App\Subscription ;
use \Redirect ;
use App\RecentView ;
use App\CategoryVideo;
use App\LanguageVideo;
use App\Episode;
use App\LiveStream;
use App\Audio;
use App\StorageSetting;
use App\PpvPurchase;
use App\Language;
use App\LoggedDevice;
use App\GuestLoggedDevice;
use App\UserTranslation;

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

                        // $space_usage = intval(round($spaceusage  / 1024 ,3)).' '.'GB';	
                        $space_disk = intval(round($spacedisk  / 1024 ,3)).' '.'GB';	
                        if(!empty($spaceusage)){

                            $spaceusage_array = explode('.', $spaceusage);

                            if(!empty($spaceusage_array[0]) && $spaceusage_array[0] >  0 ){
                                $space_usage = intval(round($spaceusage  / 1024 ,3)).' '.'GB';	
                            }else{
                                $spaceusage =  $spaceusage_array[1];
                                $spaceusage = '009765625'; 

                                $space_str = (string) $spaceusage;

                                // Remove leading zeros
                                $space_str = ltrim($space_str, '0');

                                // If the resulting string is empty, set it to '0'
                                if ($space_str === '') {
                                    $space_str = '0';
                                }
                                $space_usage = $spaceusage_array[0].'.'.substr($space_str, 0, 3).' '.'TB';
                                        // If space usage exceeds 1 TB, round it to the nearest TB
                                    // if (intval($spaceusage) >= 1024) {
                                    //     $space_usage = substr(round(intval($spaceusage) / 1024), 0, 3) . ' ' . 'GB';
                                    // }
                            }
                            
                        }else{
                            $space_usage = intval(round($spaceusage  / 1024 ,3)).' '.'GB';	
                        }

                        
                        $terabytes = $spacedisk / 1024 / 1024; 
                
                        $space_disk = number_format($terabytes, 2) . " TB.";
                        
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
        $top_rated_videos = Video::orderBy('rating','DESC')->limit(10)->get();
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

    public function getFolderStorageData()
    {
        try {
           
            $directory = 'public/uploads';

            $command = ['du', '-h', '--max-depth=1', $directory];
            
            $directoryProcess = new Process($command);
            $directoryProcess->run();
            
            if (!$directoryProcess->isSuccessful()) {
                throw new ProcessFailedException($directoryProcess);
            }
            
            $directoryOutput = $directoryProcess->getOutput();

            $directoryLines = explode("\n", trim($directoryOutput));
            $directoryDetails = [];

            foreach ($directoryLines as $line) {
                list($size, $path) = preg_split('/\s+/', $line, 2);
                $directoryDetails[] = [
                    'size' => $size,
                    'path' => $path,
                ];
            }

            return response()->json([
                'status'  => true,
                'message' => 'Retrieved memory and directory details successfully.',
                'data'    => $directoryDetails,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'An error occurred.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function getStorageData(): JsonResponse
    {
        try {
            $process = new Process(['du', '-sh']);
            $process->run();

            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }

            $storage_vai_symfony = $process->getOutput();

            return response()->json(['storage_vai_symfony' => "Total Storage : ".$storage_vai_symfony]);

        } catch (\Throwable $th) {
            return response()->json(['storage_vai_symfony' => 'An error occurred while fetching storage data.'], 500);
        }
    }

    public function Masterlist()
    {
        try {

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
    
                // $Episode = Episode::Select('episodes.*','series.title as series_title','series.access as series_access','series_seasons.access as series_seasons_access')->leftjoin('series', 'series.id', '=', 'episodes.series_id')
                //             ->leftjoin('series_seasons', 'series_seasons.id', '=', 'episodes.season_id')->orderBy('created_at', 'DESC')->get();
    
                $Episode = Episode::select(
                                        'episodes.*',
                                        'series.title as series_title',
                                        'series.access as series_access',
                                        'series_seasons.access as series_seasons_access',
                                        'moderators_users.username as moderator_username'
                                    )
                                    ->leftJoin('series', 'series.id', '=', 'episodes.series_id')
                                    ->leftJoin('series_seasons', 'series_seasons.id', '=', 'episodes.season_id')
                                    ->leftJoin('moderators_users', 'moderators_users.id', '=', 'series.user_id')
                                    ->orderBy('episodes.created_at', 'DESC')
                                    ->get();
    
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

        } catch (\Throwable $th) {
            return abort(404);
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
            

            $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
            $userIp = $geoip->getip();

            if(!Auth::guest()){

                $Setting =  Setting::first();
                $data = Session::all();
                $subuser_id = (!empty($data['subuser_id'])) ? $data['subuser_id'] : null ;
                $Subuserranslation = UserTranslation::where('multiuser_id',$subuser_id)->first();
                $UserTranslation = UserTranslation::where('user_id',Auth::user()->id)->first();

                if($subuser_id != null){
                    $Subuserranslation = UserTranslation::where('multiuser_id',$subuser_id)->first();
                    if(!empty($Subuserranslation)){
                        UserTranslation::where('multiuser_id',$subuser_id)->first()->update([
                        'translate_language'  => $request->languageCode ,
                    ]);
                    }else{
                        UserTranslation::create([
                            'multiuser_id'        =>  $subuser_id,
                            'translate_language'  => $request->languageCode ,
                        ]);
                    }
                }else if(!empty($UserTranslation)){
                    UserTranslation::where('user_id',Auth::user()->id)->first()->update([
                        'translate_language'  => $request->languageCode ,
                    ]);
                }else{
                    UserTranslation::create([
                        'user_id'               =>  Auth::user()->id,
                        'translate_language'    => $request->languageCode ,
                    ]);
                }
            }else{

                $UserTranslation = UserTranslation::where('ip_address',$userIp)->first();

                if(!empty($UserTranslation)){
                    UserTranslation::where('ip_address',$userIp)->first()->update([
                    'translate_language'  => $request->languageCode ,
                ]);
                }else{
                    UserTranslation::create([
                        'ip_address'        =>  $userIp,
                        'translate_language'  => $request->languageCode ,
                    ]);
                }

            }

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

                $storage_settings = StorageSetting::first();
                    // dd($storage_settings);
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
                
                $url = "{$storage_settings->bunny_cdn_hostname}/{$storage_settings->bunny_cdn_storage_zone_name}/";
                
                $ch = curl_init();
                
                $options = array(
                    CURLOPT_URL => $url,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_HTTPHEADER => array(
                        "AccessKey: {$storage_settings->bunny_cdn_ftp_access_key}",
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
                echo"<pre>";
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


        public function BunnyCDNStream(Request $request){
            
            $client = new Client();


            $client = new \GuzzleHttp\Client();

            $response = $client->request('GET', 'https://video.bunnycdn.com/library/120702/videos?page=1&itemsPerPage=100&orderBy=date', [
            'headers' => [
                'AccessKey' => '4ff64e8f-227f-482a-8234c571e2ae-edd6-402e',
                'accept' => 'application/json',
            ],
            ]);
            echo "<pre>";
            print_r( $response->getBody()->getContents());
            exit;
            // $body = $response->getBody()->getContents();

            // dd($body);   
            $response = $client->request('GET', 'https://api.bunny.net/videolibrary/120702?includeAccessKey=false', [
                'headers' => [
                'AccessKey' => 'ed136712-3082-4ed2-a942-2aa01890bc2fa25f5d0c-fa5b-4738-aeb2-cdd4c9e22854 ',
                'accept' => 'application/json',
                ],
            ]);


        }

    public function FFplayoutlogin(Request $request)
        {
            // Get username and password from the request
            $username = 'admin';
            $password = 'o737{@&|3TCr';

            // Create a Guzzle client instance
            $client = new Client();

            try {
                // Send a POST request to the authentication endpoint
                $response = $client->post('http://69.197.189.34:8787/auth/login/', [
                    'headers' => [
                        'Content-Type' => 'application/json',
                    ],
                    'json' => [
                        'username' => $username,
                        'password' => $password,
                    ],
                ]);

                // Get the response body
                $body = $response->getBody()->getContents();

                // Decode the JSON response
                $responseData = json_decode($body, true);

                // Extract the token from the response data
                $token = $responseData['user']['token'];
            
                // Get channel data from the request
                $channelData = [
                    'name' => 'Channel 2',
                    'preview_url' => 'http://69.197.189.34:8787/live/stream.m3u8',
                    'config_path' => '/etc/ffplayout/channel2.yml',
                    'extra_extensions' => 'jpg,jpeg,png,mp4,mov,avi',
                    'service' => 'ffplayout@channel2.service',
                ];
            

                // Send a POST request to the channel creation endpoint
                $responses = $client->post('http://69.197.189.34:8787/api/channel/', [
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'Authorization' => 'Bearer ' . $token,
                    ],
                    'json' => $channelData,
                ]);

                // Get the response body
                $bodys = $responses->getBody()->getContents();
                // Send a GET request to the channel endpoint
                $responsechannels = $client->get('http://69.197.189.34:8787/api/channels', [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $token,
                    ],
                ]);

                // Get the response body
                $bodyresponsechannels = $responsechannels->getBody()->getContents();

                // Decode the JSON response

                // Decode the JSON response
                $channelsresponseData = json_decode($bodyresponsechannels, true);
            dd($channelsresponseData);
            
                // Return the JSON response
                return response()->json(json_decode($bodys), $responses->getStatusCode());
            } catch (RequestException $e) {
                // Handle request exceptions (e.g., connection errors, 4xx, 5xx errors)
                // You can customize the error handling based on your requirements
                return $e->getMessage();
            }
        }
}
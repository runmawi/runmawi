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

class AdminDashboardController extends Controller
{
   
    public function Index()
    {

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
            }else{
            
        $videocategory = VideoCategory::get();
        $categoryvideo = CategoryVideo::get();
        foreach($videocategory as $key => $category){
            // $video_category['name_category'] = $category->name;
            $video_category[$category->name] = CategoryVideo::where('category_id','=',$category->id)->count();
            // $video_category[$category->name] = Video::where('video_category_id','=',$category->id)->count();
        }

        $recomendeds = Video::select('videos.*','video_categories.name as categories_name','categoryvideos.category_id as categories_id')
        ->Join('categoryvideos', 'videos.id', '=', 'categoryvideos.video_id')
        ->Join('video_categories', 'categoryvideos.category_id', '=', 'video_categories.id')
        // ->where('videos.id','!=',$vid)
        ->limit(10)->get();
        
        // dd($video_category);

         $settings = Setting::first();
        
         $total_subscription = Subscription::where('stripe_status','=','active')->count();
        
         $total_videos = Video::where('active','=',1)->count();
        
         $total_ppvvideos = PpvVideo::where('active','=',1)->count();
         
        $total_recent_subscription = Subscription::orderBy('created_at', 'DESC')->whereDate('created_at', '>', \Carbon\Carbon::now()->today())->count();
        $top_rated_videos = Video::where("rating",">",7)->get();
        $recent_views = RecentView::limit(10)->orderBy('id','DESC')->get();
        $recent_view = $recent_views->unique('video_id');
        $page = 'admin-dashboard';
        $data = array(
                'settings' => $settings,
                'total_subscription' => $total_subscription,
                'total_recent_subscription' => $total_recent_subscription,
                'total_videos' => $total_videos,
                'top_rated_videos' => $top_rated_videos,
                'recent_views' => $recent_view,
                'page' => $page,
                'total_ppvvideos' => $total_ppvvideos,
                'video_category' => $video_category

        );
        
		return View::make('admin.dashboard', $data);
    }
        
    }

    public function Masterlist()

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
}

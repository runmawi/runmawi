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


class AdminDashboardController extends Controller
{
   
    public function Index()
    {
        // exit();
           if (!Auth::user()->role == 'admin')
            {
                return redirect('/home');
            }
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

    public function Masterlist()
    {
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

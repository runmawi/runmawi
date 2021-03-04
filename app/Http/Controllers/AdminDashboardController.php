<?php

namespace App\Http\Controllers;

use \App\User as User;
use \App\Setting as Setting;
use \App\Video as Video;
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

class AdminDashboardController extends Controller
{
   
    public function Index()
    {
        
           if (!Auth::user()->role == 'admin')
            {
                return redirect('/home');
            }
        
         $settings = Setting::first();
        
         $total_subscription = Subscription::where('stripe_status','=','active')->count();
        
         $total_videos = Video::where('active','=',1)->count();
        
         $total_ppvvideos = PpvVideo::where('active','=',1)->count();
         
        $total_recent_subscription = Subscription::orderBy('created_at', 'DESC')->whereDate('created_at', '>', \Carbon\Carbon::now()->today())->count();
        $top_rated_videos = Video::where("rating",">",7)->get();
        $recent_views = RecentView::all();
        $page = 'admin-dashboard';
        $data = array(
                'settings' => $settings,
                'total_subscription' => $total_subscription,
                'total_recent_subscription' => $total_recent_subscription,
                'total_videos' => $total_videos,
                'top_rated_videos' => $top_rated_videos,
                'recent_views' => $recent_views,
                'page' => $page,
                'total_ppvvideos' => $total_ppvvideos
        );
        
		return View::make('admin.dashboard', $data);
    }
    
    
}

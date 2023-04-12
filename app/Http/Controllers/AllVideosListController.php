<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\AdminLandingPage;
use App\CurrencySetting;
use App\ThumbnailSetting;
use App\VideoCategory;
use App\HomeSetting;
use App\Multiprofile;
use App\Setting;
use App\Video;
use App\User;
use Session;
use Theme;
use Auth;

class AllVideosListController extends Controller
{
    public function __construct()
    {
        $this->settings = Setting::first();

        $this->videos_per_page = $this->settings->videos_per_page;

        $this->Theme = HomeSetting::pluck('theme_choosen')->first();

        Theme::uses($this->Theme);

    }

    public function all_videos(Request $request)
    {
        try {

            if($this->settings->enable_landing_page == 1 && Auth::guest()){

                $landing_page_slug = AdminLandingPage::where('status',1)->pluck('slug')->first() ? AdminLandingPage::where('status',1)->pluck('slug')->first() : "landing-page" ;
    
                return redirect()->route('landing_page', $landing_page_slug );
            }
    
            // All videos 

            $multiuser = Session::get('subuser_id');
         
            $Mode = $multiuser != null ?  Multiprofile::where('id', $multiuser)->first() : User::where('id', Auth::User()->id)->first();
           
            $check_Kidmode = $Mode['user_type'] != null && $Mode['user_type'] == "Kids" ? 1 : 0 ;
    
            $videos = Video::where('active', '=', '1')->where('status', '=', '1')->where('draft', '=', '1');
    
                if (Geofencing() != null && Geofencing()->geofencing == 'ON')
                {
                    $videos = $videos->whereNotIn('videos.id', Block_videos());
                }

                if( $check_Kidmode == 1 )
                {
                    $videos = $videos->whereBetween('videos.age_restrict', [ 0, 12 ]);
                }
                    
                $videos = $videos->latest('videos.created_at')->paginate($this->settings->videos_per_page);
    
                $PPV_settings = Setting::where('ppv_status', '=', 1)->first();
                $ppv_gobal_price = !empty($PPV_settings) ? $PPV_settings->ppv_price : null;
           
            $respond_data = array(
                'videos'    => $videos,
                'ppv_gobal_price'  => $ppv_gobal_price,
                'currency'         => CurrencySetting::first(),
                'ThumbnailSetting' => ThumbnailSetting::first(),
            );
    
            return Theme::view('All-Videos.All_videos',['respond_data' => $respond_data]);

        } catch (\Throwable $th) {
            // return $th->getMessage();
            return abort(404);
        }
       
    }

    public function learn(Request $request)
    {
        try {

            if($this->settings->enable_landing_page == 1 && Auth::guest()){

                $landing_page_slug = AdminLandingPage::where('status',1)->pluck('slug')->first() ? AdminLandingPage::where('status',1)->pluck('slug')->first() : "landing-page" ;
    
                return redirect()->route('landing_page', $landing_page_slug );
            }
    
            
            $multiuser = Session::get('subuser_id');
             
            $Mode = $multiuser != null ?  Multiprofile::where('id', $multiuser)->first() : User::where('id', Auth::User()->id)->first();
           
            $check_Kidmode = $Mode['user_type'] != null && $Mode['user_type'] == "Kids" ? 1 : 0 ;
    

                    // All Education Catogery videos - only for Nemisha
             
            $data = VideoCategory::query()->with(['category_videos' => function ($videos) use ($check_Kidmode)  {
    
                $videos->select('videos.id','title','slug','year','rating','access','publish_type','global_ppv','publish_time','ppv_price','duration','rating','image','featured','age_restrict')
                        ->where('videos.active',1)->where('videos.status', 1)->where('videos.draft',1);
          
                    if( Geofencing() !=null && Geofencing()->geofencing == 'ON')
                    {
                        $videos = $videos->whereNotIn('videos.id',Block_videos());
                    }
          
                    if( $check_Kidmode == 1 )
                    {
                        $videos = $videos->whereBetween('videos.age_restrict', [ 0, 12 ]);
                    }
          
                    $videos = $videos->latest('videos.created_at')->get();
                }])
                ->select('video_categories.id','video_categories.name', 'video_categories.slug', 'video_categories.in_home','video_categories.order')
                ->where('video_categories.in_home',1)
                ->where('video_categories.id',19)
                ->orderBy('video_categories.order')
                ->paginate($this->settings->videos_per_page);
    
                $PPV_settings = Setting::where('ppv_status', '=', 1)->first();
                $ppv_gobal_price = !empty($PPV_settings) ? $PPV_settings->ppv_price : null;
           
            $respond_data = array(
                'videos'    => $data,
                'ppv_gobal_price'  => $ppv_gobal_price,
                'currency'         => CurrencySetting::first(),
                'ThumbnailSetting' => ThumbnailSetting::first(),
            );
    
            return Theme::view('All-Videos.All_videos',['respond_data' => $respond_data]);

        } catch (\Throwable $th) {
            // return $th->getMessage();
            return abort(404);
        }
    }

    public function all_livestream()
    {
        $livetreams = LiveStream::where('active', '=', '1')->orderBy('created_at', 'DESC')
        ->get();
    }
}

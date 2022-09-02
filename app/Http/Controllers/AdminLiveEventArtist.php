<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;
use \App\User as User;
use \Redirect as Redirect;
use Illuminate\Http\Request;
use URL;
use App\LiveStream as LiveStream;
use App\LiveCategory as LiveCategory;
use App\VideoResolution as VideoResolution;
use App\VideosSubtitle as VideosSubtitle;
use App\Language as Language;
use App\Subtitle as Subtitle;
use App\Setting as Setting;
use App\Tag as Tag;
use Auth;
use Hash;
use Illuminate\Support\Facades\Cache;
use View;
use Session;
use Illuminate\Support\Str;
use App\Users as Users;
use App\LiveLanguage as LiveLanguage;
use App\CategoryLive as CategoryLive;
use App\RTMP;
use Streaming\Representation;
use GuzzleHttp\Client;
use GuzzleHttp\Message\Response;
use App\InappPurchase;
use Intervention\Image\Facades\Image;
use Intervention\Image\Filters\DemoFilter;


class AdminLiveEventArtist extends Controller
{

    public function __construct()
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

    }
    

    public function index()
    {
        $Stream_key = Session::get('Stream_key');
        $Stream_error =Session::get('Stream_error');
        $Rtmp_url = Session::get('Rtmp_url');
        $title = Session::get('title');
        $hls_url = Session::get('hls_url');
       
        if(!empty($search_value)):
            $videos = LiveStream::where('title', 'LIKE', '%'.$search_value.'%')->orderBy('created_at', 'desc')->paginate(9);
        else:
            $videos = LiveStream::orderBy('created_at', 'DESC')->paginate(9);
        endif;
    
        $user = Auth::user();

        $data = array(
            'videos' => $videos,
            'user' => $user,
            'admin_user' => Auth::user(),
            'Settings'  => Setting::first(),
            'Video_encoder_Status' => '0',
            'Stream_key' => $Stream_key,
            'Stream_error' => $Stream_error ? $Stream_error : 0 ,
            'Rtmp_url'  => $Rtmp_url ? $Rtmp_url : null ,
            'title' => $title ? $title : null,
            'hls_url' => $hls_url ? $hls_url : null,
            );

        return view('admin.live_event_artist.index',$data);
    }

    public function create(Request $request){

        $user =  User::where('id',1)->first();
        $duedate = $user->package_ends;
        $current_date = date('Y-m-d');

        if ($current_date > $duedate)
        {
            $client = new Client();
            $url = "https://flicknexs.com/userapi/allplans";
            $params = [ 'userid' => 0 ];
    
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
            $data = array(
                'headline' => '<i class="fa fa-plus-circle"></i> New Video',
                'post_route' => URL::to('admin/livestream/store'),
                'button_text' => 'Add New Video',
                'admin_user' => Auth::user(),
                'video_categories' => LiveCategory::all(),
                'languages' => Language::all(),
                'category_id' => [],
                'languages_id' => [],
                'liveStreamVideo_error' => '0',
                'Rtmp_urls' => RTMP::all(),
                'InappPurchase' => InappPurchase::all(),
                );
                return view('admin.live_event_artist.create',$data);

        }
    }
}

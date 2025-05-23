<?php

namespace App\Http\Controllers;
use \App\User as User;
use \Redirect as Redirect;
use Illuminate\Http\Request;
use URL;
use App\Video as Video;
use App\VideoCategory as VideoCategory;
use App\VideoResolution as VideoResolution;
use App\Menu as Menu;
use App\VideosSubtitle as VideosSubtitle;
use App\Language as Language;
use App\Subtitle as Subtitle;
use App\Setting as Setting;
use App\Tag as Tag;
use Auth;
use Hash;
use Illuminate\Support\Facades\Cache;
use Image;
use View;
use GuzzleHttp\Client;
use GuzzleHttp\Message\Response;
use App\SignupMenu as SignupMenu;
use App\CPPSignupMenu;
use App\ChannelSignupMenu;

class AdminSignupMenuController extends Controller
{
    /**
     * Display a listing of videos
     *
     * @return Response
     */
    public function index()
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
        }else{

            $SignupMenu = SignupMenu::first();
            $user = Auth::user();

            $data = array(
                'SignupMenu' => $SignupMenu,
                'user' => $user,
                'admin_user' => Auth::user()
            );

        return View::make('admin.signup_menu.index', $data);
        }
    }

    public function store(Request $request){
        
        $input = $request->all();
        
        
        $SignupMenu = SignupMenu::first();
        if(!empty($SignupMenu)){
            $SignupMenu = SignupMenu::first();
        }else{
            $SignupMenu = new SignupMenu;
        }
        $SignupMenu->username               =  $request->has('username') ? 1 : 0 ?? 0; 
        $SignupMenu->email                  =  $request->has('email') ? 1 : 0 ?? 0;   
        $SignupMenu->mobile                 =  $request->has('mobile') ? 1 : 0 ?? 0;  
        $SignupMenu->avatar                 =  $request->has('avatar') ? 1 : 0 ?? 0;  
        $SignupMenu->password               =  $request->has('password') ? 1 : 0 ?? 0;  
        $SignupMenu->password_confirm       =  $request->has('password_confirm') ? 1 : 0 ?? 0;   
        $SignupMenu->country                =  $request->has('country') ? 1 : 0 ?? 0;   
        $SignupMenu->state                  =  $request->has('state') ? 1 : 0 ?? 0;   
        $SignupMenu->city                   =  $request->has('city') ? 1 : 0 ?? 0;   
        $SignupMenu->support_username       =  $request->has('support_username') ? 1 : 0 ?? 0; 
        $SignupMenu->dob                    =  $request->has('dob') ? 1 : 0 ?? 0;   
        $SignupMenu->gender                 =  $request->has('gender') ? 1 : 0 ?? 0;   
        $SignupMenu->save();  
    
            return redirect()->route('signupindex');
    
        }
          
    
        public function cppindex()
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
            }else{
    
                $CPPSignupMenu = CPPSignupMenu::first();
                $user = Auth::user();
    
                $data = array(
                    'CPPSignupMenu' => $CPPSignupMenu,
                    'user' => $user,
                    'admin_user' => Auth::user()
                );
    
            return View::make('admin.signup_menu.CPP_Index', $data);
            }
        }
    
        public function CPP_Signupmenu_Store(Request $request){
            
            $input = $request->all();
            
            
            $CPPSignupMenu = CPPSignupMenu::first();
            if(!empty($CPPSignupMenu)){
                $CPPSignupMenu = CPPSignupMenu::first();
            }else{
                $CPPSignupMenu = new CPPSignupMenu;
            }
            $CPPSignupMenu->username               =  $request->has('username') ? 1 : 0 ?? 0; 
            $CPPSignupMenu->email                  =  $request->has('email') ? 1 : 0 ?? 0;   
            $CPPSignupMenu->mobile                 =  $request->has('mobile') ? 1 : 0 ?? 0;  
            $CPPSignupMenu->image                  =  $request->has('image') ? 1 : 0 ?? 0;  
            $CPPSignupMenu->upload_video           =  $request->has('upload_video') ? 1 : 0 ?? 0;   
            $CPPSignupMenu->password               =  $request->has('password') ? 1 : 0 ?? 0;  
            $CPPSignupMenu->password_confirm       =  $request->has('password_confirm') ? 1 : 0 ?? 0;   
            $CPPSignupMenu->thumbnail_image        =  $request->has('thumbnail_image') ? 1 : 0 ?? 0;   
            $CPPSignupMenu->socialmedia_details    =  $request->has('socialmedia_details') ? 1 : 0 ?? 0;   
            $CPPSignupMenu->bank_details           =  $request->has('bank_details') ? 1 : 0 ?? 0;   
            $CPPSignupMenu->gender                 =  $request->has('gender') ? 1 : 0 ?? 0;   
            $CPPSignupMenu->save();  
        
        return redirect()->route('cppsignupindex');
        
    }


    public function channelindex()
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
        }else{

            $ChannelSignupMenu = ChannelSignupMenu::first();
            $user = Auth::user();

            $data = array(
                'ChannelSignupMenu' => $ChannelSignupMenu,
                'user' => $user,
                'admin_user' => Auth::user()
            );

        return View::make('admin.signup_menu.Channel_Index', $data);
        }
    }

    public function Channel_Signupmenu_Store(Request $request){
        
        $input = $request->all();
        
        
        $ChannelSignupMenu = ChannelSignupMenu::first();
        if(!empty($ChannelSignupMenu)){
            $ChannelSignupMenu = ChannelSignupMenu::first();
        }else{
            $ChannelSignupMenu = new ChannelSignupMenu;
        }
        $ChannelSignupMenu->username               =  $request->has('username') ? 1 : 0 ?? 0; 
        $ChannelSignupMenu->email                  =  $request->has('email') ? 1 : 0 ?? 0;   
        $ChannelSignupMenu->mobile                 =  $request->has('mobile') ? 1 : 0 ?? 0;  
        $ChannelSignupMenu->image                  =  $request->has('image') ? 1 : 0 ?? 0;  
        $ChannelSignupMenu->upload_video           =  $request->has('upload_video') ? 1 : 0 ?? 0;   
        $ChannelSignupMenu->password               =  $request->has('password') ? 1 : 0 ?? 0;  
        $ChannelSignupMenu->password_confirm       =  $request->has('password_confirm') ? 1 : 0 ?? 0;   
        $ChannelSignupMenu->thumbnail_image       =  $request->has('thumbnail_image') ? 1 : 0 ?? 0;   
        $ChannelSignupMenu->socialmedia_details       =  $request->has('socialmedia_details') ? 1 : 0 ?? 0;   
        $ChannelSignupMenu->bank_details       =  $request->has('bank_details') ? 1 : 0 ?? 0;   
        $ChannelSignupMenu->gender                 =  $request->has('gender') ? 1 : 0 ?? 0;   

        $ChannelSignupMenu->save();  
    
        return redirect()->route('channelsignupindex');

    }
}

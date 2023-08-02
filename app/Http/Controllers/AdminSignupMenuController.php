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
        $SignupMenu->save();  
    
            return redirect()->route('signupindex');
    
        }
          
    

}

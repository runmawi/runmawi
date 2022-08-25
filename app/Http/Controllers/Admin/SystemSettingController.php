<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use \Redirect as Redirect;
use Illuminate\Http\Request;
use App\SystemSetting as SystemSetting;
use App\User as User;
use App\Setting as Setting;
use View;
use GuzzleHttp\Client;
use GuzzleHttp\Message\Response;

class SystemSettingController extends Controller
{
   public function index(){
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
       $system = SystemSetting::first();
       $system_settings = \DB::table('system_settings')->get();

       $data = array(
                'system' => $system
       );
       
       
       return view('admin.systemsettings.index',$data);
    }
   }
    public function save(Request $request){
        $data = $request->all();

        $settings = SystemSetting::find(1);
        if(empty($settings)){

        $settings = new SystemSetting;

            if (!empty($request->facebook)){
                $settings->facebook = $request->facebook;   
                } else {
                    $settings->facebook = 0;  
                }
                
                if (!empty($request->google)){
                $settings->google = $request->google;   
                } else {
                    $settings->google = 0;  
                }
                
                $settings->facebook_client_id = $request->facebook_client_id;
                $settings->facebook_secrete_key = $request->facebook_secrete_key;
                $settings->facebook_callback = $request->facebook_callback;
                $settings->google_client_id = $request->google_client_id;
                $settings->google_secrete_key = $request->google_secrete_key;
                $settings->google_callback = $request->google_callback;
                $settings->save();
                return Redirect::back();

        }else{

            if (!empty($request->facebook)){
            $settings->facebook = $request->facebook;   
            } else {
                $settings->facebook = 0;  
            }
            
            if (!empty($request->google)){
            $settings->google = $request->google;   
            } else {
                $settings->google = 0;  
            }
            
            $settings->facebook_client_id = $request->facebook_client_id;
            $settings->facebook_secrete_key = $request->facebook_secrete_key;
            $settings->facebook_callback = $request->facebook_callback;
            $settings->google_client_id = $request->google_client_id;
            $settings->google_secrete_key = $request->google_secrete_key;
            $settings->google_callback = $request->google_callback;
            $settings->save();
            return Redirect::back();
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\HomeSetting;
use App\Setting;
use App\User;
use URL;
use Auth;
use View;


class AdminSliderSettingController extends Controller
{
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
        }

        else{
            $slider_choosen = HomeSetting::pluck('slider_choosen')->first();
            $user = Auth::user();

            $data = array(
                'slider_choosen' => $slider_choosen,
                'admin_user'	=> $user,
                );

            return View::make('admin.slider.index', $data);
        }
    }

    public function set_slider(Request $request)
    {
        HomeSetting::first()->update(['slider_choosen' => $request->id ]);

        return 'success';
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use \Redirect as Redirect;
use GuzzleHttp\Client;
use GuzzleHttp\Message\Response;
use \App\Setting as Setting;
use \App\User as User;
use View;

class ClearCacheController extends Controller
{
   
    public function index()
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

        }else{
            return view('admin.cache.index');

        }
    }

    public function clear_caches()
    {
        try {
            Artisan::call('cache:clear');
            Artisan::call('view:clear');
            return response()->json(['message'=>"true"]);

        } catch (\Throwable $th) {

            return response()->json(['message'=>"false"]);
        }
    }

    public function clear_view_cache()
    {
        try {
            Artisan::call('view:clear');

            return response()->json(['message'=>"true"]);

        } catch (\Throwable $th) {

            return response()->json(['message'=>"false"]);

        }
       
    }

    public function Env_index(){

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
           
            return View('admin.env_debug.index');

        }
    }

    public function Env_AppDebug(Request $request)
    {

        try {
             
                $Env_path = realpath(('.env'));

                $status = $request->status == "true" ? "true" : 'false';
                $Replace_data =array(
                    'APP_DEBUG' => $status,
                );

                file_put_contents($Env_path, implode('', 
                        array_map(function($Env_path) use ($Replace_data) {
                            return   stristr($Env_path,'APP_DEBUG') ? "APP_DEBUG=".$Replace_data['APP_DEBUG']."\n" : $Env_path;
                        }, file($Env_path))
                ));

                return response()->json(['message'=>"true"]);

        } catch (\Throwable $th) {
           return response()->json(['message'=>"false"]);
        }
    }

}

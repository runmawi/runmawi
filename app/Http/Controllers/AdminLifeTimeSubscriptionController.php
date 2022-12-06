<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \Redirect as Redirect;
use App\AdminLifeTimeSubscription;
use App\CurrencySetting;
use App\User;
use App\Devices;

class AdminLifeTimeSubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $user =  User::where('id',1)->first();
        $duedate = $user->package_ends;
        $current_date = date('Y-m-d');

        if ($current_date > $duedate)
        {
            $client = new Client();
            $url = "https://flicknexs.com/userapi/allplans";
            $params = ['userid' => 0 ];
            $headers = [  'api-key' => 'k3Hy5qr73QhXrmHLXhpEh6CQ'];

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
                'AdminLifeTimeSubscription' => AdminLifeTimeSubscription::first(),
                'allCurrency'=> CurrencySetting::first() ,
                'devices' => Devices::all() ,
            );

            return view ('admin.life_time_subscription.index',$data);
        }
    }

    public function update(Request $request)
    {

        $user =  User::where('id',1)->first();
        $duedate = $user->package_ends;
        $current_date = date('Y-m-d');

        if ($current_date > $duedate)
        {
            $client = new Client();
            $url = "https://flicknexs.com/userapi/allplans";
            $params = ['userid' => 0 ];
            $headers = [  'api-key' => 'k3Hy5qr73QhXrmHLXhpEh6CQ'];

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

            $AdminLifeTimeSubscription = AdminLifeTimeSubscription::first();

            if( $AdminLifeTimeSubscription == null ){

                AdminLifeTimeSubscription::create([
                    'name'  => $request->name ,
                    'price' => $request->price , 
                    'devices' => $request->devices ? implode(",",$request->devices) : null ,
                    'status' => $request->status  == "on"  ? 1 : 0 ,
                ]);

            }else{

                AdminLifeTimeSubscription::first()->update([
                    'name'  => $request->name ,
                    'price' => $request->price , 
                    'devices' => $request->devices ? implode(",",$request->devices) : null ,
                    'status' => $request->status  == "on"  ? 1 : 0 ,
                ]);
            }

            return redirect()->route('Life-time-subscription-index')->with(array('message' => 'Successfully Updated !!', 'note_type' => 'success') );
        }
    }
}
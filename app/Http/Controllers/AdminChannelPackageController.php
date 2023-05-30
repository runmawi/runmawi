<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Channel;
use App\ChannelPackage;
use Auth;
use View;
use GuzzleHttp\Client;
use GuzzleHttp\Message\Response;
use App\User;
use App\Setting;

class AdminChannelPackageController extends Controller
{

    public function index(Request $request)
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
        }else if(check_storage_exist() == 0){
            $settings = Setting::first();

            $data = array(
                'settings' => $settings,
            );

            return View::make('admin.expired_storage', $data);
        }else{

        
            $data = array(
                'Channel_list' => ChannelPackage::get() ,
            );
        }
       return view('admin.channel_package.index',$data);
    }

    public function create(Request $request)
    {
        $data = array(
            'post_route' => route('channel_package_store') ,
            'Channel_list' => Channel::where('status',1)->get(),
        );

        return view('admin.channel_package.create',$data);
    }

    public function store(Request $request)
    {

        ChannelPackage::create([
           'channel_package_name'    => $request->channel_package_name,
           'channel_package_plan_id' => $request->channel_package_plan_id,
           'channel_package_price'   => $request->channel_package_price,
           'channel_plan_interval'   => $request->channel_plan_interval,
           'add_channels'            => json_encode($request->add_channels) ,
           'status'                  => !empty($request->status) ? 1 : 0 ,
        ]);

        return redirect()->route('channel_package_index')->with(array('message' => 'New Channel Package Successfully Added!', 'note_type' => 'success') );
    }

    public function edit(Request $request,$id)
    {
        $channel_list= ChannelPackage::where('id', $id)->pluck('add_channels')->first();

        $data = array(
            'post_route' => route('channel_package_update',$id) ,
            'Channel_list' => Channel::where('status',1)->get(),
            'Channel_package' => ChannelPackage::where('id',$id)->first(),
            'channel_list_selected' => Channel::whereIn('id', json_decode($channel_list))->pluck('id')->toArray(),
        );

        return view('admin.channel_package.edit',$data);
    }

    public function update(Request $request,$id)
    {

        ChannelPackage::where('id',$id)->update([
            'channel_package_name'    => $request->channel_package_name,
            'channel_package_plan_id' => $request->channel_package_plan_id,
            'channel_package_price'   => $request->channel_package_price,
            'channel_plan_interval'   => $request->channel_plan_interval,
            'add_channels'            => json_encode($request->add_channels) ,
            'status'                  => !empty($request->status) ? 1 : 0 ,
         ]);

        return redirect()->route('channel_package_index')->with(array('message' => 'New Channel Package Updated Successfully Added!', 'note_type' => 'success') );

    }

    public function delete(Request $request,$id)
    {
        ChannelPackage::where('id',$id)->delete();

        return redirect()->route('channel_package_index')->with(array('message' => 'New Channel Package Deleted Successfully Added!', 'note_type' => 'success') );
    }
}

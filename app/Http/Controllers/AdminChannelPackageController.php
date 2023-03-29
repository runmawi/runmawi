<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Channel;
use App\ChannelPackage;
use Auth;

class AdminChannelPackageController extends Controller
{
    public function index(Request $request)
    {
        $data = array(
            'Channel_list' => ChannelPackage::get() ,
        );

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

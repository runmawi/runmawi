<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\ChannelVideoScheduler;
use App\AdminEPGChannel;
use App\AdminEPG;
use App\TimeZone;
use App\User;
use View;

class AdminEPGController extends Controller
{
    public function __construct()
    {
        if(EPG_Status() == 0 ){

            $Error_msg = "EPG Restricted, Please Check the Settings";
            $url = URL::to('/admin');
            echo "<script type='text/javascript'>alert('$Error_msg'); window.location.href = '$url' </script>";
        }
    }

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

        }else if(check_storage_exist() == 0){

            $settings = Setting::first();

            $data = array(
                'settings' => $settings,
            );

            return View::make('admin.expired_storage', $data);

        }else{

            $data = array( 
                            'EPG'  => AdminEPG::where('status',1)->latest()->get()->map(function ($item) {
                                $item['channel_name'] = AdminEPGChannel::where('id',$item->epg_channel_id)->pluck('name')->first() ;
                                return $item;
                            }),
                        );
    
            return View::make('admin.EPG.index',$data);
        }
    }

    public function create()
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
                'button_text'  => 'Generate' ,
                'EPG_channels' => AdminEPGChannel::where('status',1)->get(),
                'TimeZone'     => TimeZone::get(),
            );
    
            return View::make('admin.EPG.create',$data);
        }
    }
    
    public function generate( Request $request )
    {
        try {
       
            $EPG_Channel =  AdminEPGChannel::where('id',$request->epg_channel_id)->get()
                                            ->map(function ($item) {
                                                $item['image_url'] = $item->image != null ? URL::to('public/uploads/EPG-Channel/'.$item->image ) : default_vertical_image_url() ;
                                                $item['Player_image_url'] = $item->player_image != null ?  URL::to('public/uploads/EPG-Channel/'.$item->player_image ) : default_horizontal_image_url();
                                                $item['Logo_url'] = $item->logo != null ?  URL::to('public/uploads/EPG-Channel/'.$item->logo ) : default_vertical_image_url();
                                                return $item;
                                            })->first();


            $unique_channel_id = $EPG_Channel->unique_channel_id ;
            
            $Request_TimeZone = TimeZone::where('id',$request->time_zone_id)->first();

            $epg_start_date = Carbon::createFromFormat('Y-m-d', $request->epg_start_date)->setTimezone( $Request_TimeZone->time_zone )->format('n-j-Y');
            $epg_end_date   = Carbon::createFromFormat('Y-m-d', $request->epg_end_date)->setTimezone( $Request_TimeZone->time_zone )->format('n-j-Y') ;

            $ChannelVideoScheduler =  ChannelVideoScheduler::where('channe_id',$request->epg_channel_id)  
                                                            ->whereBetween('choosed_date', [$epg_start_date, $epg_end_date])
                                                            ->get();


            // XML 

            $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><tv></tv>');

            $channel = $xml->addChild('channel');
            $channel->addAttribute('id', $unique_channel_id);
            $channel->addChild('display-name', $EPG_Channel->name );
            $channel->addChild('icon')->addAttribute( 'src',$EPG_Channel->Logo_url );

            $programs = array();

            foreach ($ChannelVideoScheduler as $data) {

                $TimeZone = TimeZone::where('id',$data->time_zone)->first();

                $initial_start_time   = Carbon::createFromFormat('H:i:s', $data->start_time , $TimeZone->time_zone);
                $converted_start_time = $initial_start_time->setTimezone( $Request_TimeZone->time_zone )->format('h:i:s A');

                $initial_end_time   = Carbon::createFromFormat('H:i:s', $data->end_time , $TimeZone->time_zone);
                $converted_end_time = $initial_end_time->setTimezone( $Request_TimeZone->time_zone )->format('h:i:s A');

                $International_standard_time_start_time = ( ($data->choosed_date) . ' ' . $converted_start_time ) ;
                $International_standard_time_stop_time  = ( $data->choosed_date   . ' ' . $converted_end_time ) ;

                $start_time = Carbon::createFromFormat('n-d-Y h:i:s A', $International_standard_time_start_time)->format('YmdHis') . " " . TimeZone::where('id',$Request_TimeZone->time_zone )->pluck('utc_difference')->first();
                
                $stop_time =  Carbon::createFromFormat('n-d-Y h:i:s A', $International_standard_time_stop_time)->format('YmdHis') . " " .  TimeZone::where('id',$Request_TimeZone->time_zone )->pluck('utc_difference')->first(); 
            

                $programs[] = array(
                    'start' => $start_time,
                    'stop'  => $stop_time, 
                    'title' => $data->socure_title,
                    'desc'  => $data->description ,
                );
            }

            foreach ($programs as $program) {

                $programElement = $xml->addChild('programme');
                $programElement->addAttribute('start', $program['start']);
                $programElement->addAttribute('stop', $program['stop']);
                $programElement->addAttribute('channel', $unique_channel_id);
                $programElement->addChild('title', $program['title'], URL::to('/') );
                $programElement->addChild('desc', $program['desc'],  URL::to('/') );
                
            }

            $dom = dom_import_simplexml($xml)->ownerDocument;
            $dom->formatOutput = true;

            $filename = $unique_channel_id.'.xml';
            $xmlFilePath = public_path('uploads/EPG-Channel/' . $filename );

            $dom->save($xmlFilePath);

            AdminEPG::create([ 
                'epg_channel_id'    =>  $request->epg_channel_id ,
                'unique_channel_id' =>  $unique_channel_id ,
                'epg_format'        =>  $request->epg_format ,
                'epg_start_date'    =>  $request->epg_start_date ,
                'epg_end_date'      =>  $request->epg_end_date ,
                'include_gaps_status' => !empty($request->include_gaps_status)  ? 1 : 0 ,
                'xml_file_name'       => $filename ,
                'time_zone_id'        => $request->time_zone_id ,
                'status'              => 1 ,
            ]);
            
            return redirect()->route('admin.epg.index')->with('message', 'EPG Generated successfully.');
                 
        } catch (\Throwable $th) {
            return abort(404);
        }
    }

    public function delete($id)
    {

        try {
            $AdminEPG = AdminEPG::find($id);

            if (File::exists(base_path('public/uploads/EPG-Channel/'.$AdminEPG->xml_file_name))) {
                File::delete(base_path('public/uploads/EPG-Channel/'.$AdminEPG->xml_file_name));
            }
            
            $AdminEPG->delete();
    
            return redirect()->back()->with('message', 'EPG deleted successfully.');

        } catch (\Throwable $th) {
            return abort(404);
        }
        
    }
}
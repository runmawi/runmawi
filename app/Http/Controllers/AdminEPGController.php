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
use App\AdminEPGChannel;
use App\AdminEPG;
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

            $data = array( 'EPG'  => AdminEPG::where('status',1)->get() );
    
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
                'button_text' => 'Generate' ,
                'EPG_channels' => AdminEPGChannel::where('status',1)->get(),
            );
    
            return View::make('admin.EPG.create',$data);
        }
    }
    
    public function generate( Request $request )
    {
        
        $EPG_Channel =  AdminEPGChannel::where('id',$request->epg_channel_id)->get()->map(function ($item) {
            $item['image_url'] = $item->image != null ? URL::to('public/uploads/EPG-Channel/'.$item->image ) : default_vertical_image_url() ;
            $item['Player_image_url'] = $item->player_image != null ?  URL::to('public/uploads/EPG-Channel/'.$item->player_image ) : default_horizontal_image_url();
            $item['Logo_url'] = $item->logo != null ?  URL::to('public/uploads/EPG-Channel/'.$item->logo ) : default_vertical_image_url();
            return $item;
        })->first();

        $unique_channel_id = time().'-'.Str::uuid( $EPG_Channel->name );

        // XML 

        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><tv></tv>');

        $channel = $xml->addChild('channel');
        $channel->addAttribute('id', $unique_channel_id);
        $channel->addChild('display-name', $EPG_Channel->name );
        $channel->addChild('icon')->addAttribute( 'src',$EPG_Channel->Logo_url );

        $programs = array(

                        [
                            'start' => '20240102105446 +0000',
                             'stop' => '20240102105519 +0000', 
                             'title' => 'Big Buck Bunny',
                              'desc' => 'Loremipsum...'
                        ],

                        [
                            'start' => '20240102105446 +0000', 
                            'stop' => '20240102105519 +0000', 
                            'title' => 'Test 1 ', 
                            'desc' => 'Testing ipsum...'
                        ],

                    );

        foreach ($programs as $program) {
            $programElement = $xml->addChild('programme');
            $programElement->addAttribute('start', $program['start']);
            $programElement->addAttribute('stop', $program['stop']);
            $programElement->addAttribute('channel', $unique_channel_id);
            $programElement->addChild('title', $program['title'], 'http://test/2005/Atom');
            $programElement->addChild('desc', $program['desc'], 'http://test/2005/Atom');
        }

        $dom = dom_import_simplexml($xml)->ownerDocument;
        $dom->formatOutput = true;

        $filename = $unique_channel_id.'.xml';
        $xmlFilePath = public_path('uploads/EPG-Channel/' . $filename );

        $dom->save($xmlFilePath);

        AdminEPG::create([ 
            'name'              =>  $request->name ,
            'slug'              =>  $request->slug == null  ? Str::slug($request->name)  : Str::slug($request->slug)  ,
            'epg_channel_id'    =>  $request->epg_channel_id ,
            'unique_channel_id' =>  $unique_channel_id ,
            'epg_format'        =>  $request->epg_format ,
            'epg_start_date'    =>  $request->epg_start_date ,
            'epg_end_date'      =>  $request->epg_end_date ,
            'include_gaps_status' => !empty($request->include_gaps_status)  ? 1 : 0 ,
            'xml_file_name'       => $filename ,
            'status'              => 1 ,
        ]);
        
        return redirect()->route('admin.epg.index')->with('message', 'EPG Generated successfully.');
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
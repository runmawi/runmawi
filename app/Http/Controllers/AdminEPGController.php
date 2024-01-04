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
use Illuminate\Support\Str;
use App\AdminEPGChannel;
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
                'button_text' => 'Generate' ,
                'EPG_channels' => AdminEPGChannel::where('status',1)->get(),
            );
    
            return View::make('admin.EPG.index',$data);
        }
    }
    
    public function generate()
    {
        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><tv></tv>');

        $channel = $xml->addChild('channel');
        $channel->addAttribute('id', '2035efbb82a5d91b0ad02300bd45503d');
        $channel->addChild('display-name', 'VOD CHANNEL');
        $channel->addChild('icon')->addAttribute('src',
        'https://d10xsoss226fg9.cloudfront.net/6RvadZv5g7SZXu9hWkXRLOMuUuflt7aW/7718F46772A54819AE19147BCE9D3D6B/tg/Big_Buck_Bunny-13302-1704192520419.jpg');

        $programs = [
        ['start' => '20240102105446 +0000', 'stop' => '20240102105519 +0000', 'title' => 'Big Buck Bunny', 'desc' => 'Lorem
        ipsum...'],

        ['start' => '20240102105446 +0000', 'stop' => '20240102105519 +0000', 'title' => 'Test 1 ', 'desc' => 'Testing
        ipsum...'],

        ];

        foreach ($programs as $program) {
            $programElement = $xml->addChild('programme');
            $programElement->addAttribute('start', $program['start']);
            $programElement->addAttribute('stop', $program['stop']);
            $programElement->addAttribute('channel', '2035efbb82a5d91b0ad02300bd45503d');
            $programElement->addChild('title', $program['title'], 'http://test/2005/Atom');
            $programElement->addChild('desc', $program['desc'], 'http://test/2005/Atom');
        }

        $dom = dom_import_simplexml($xml)->ownerDocument;
        $dom->formatOutput = true;

        $xmlString = $dom->saveXML();

        $filename = 'generated_tv_schedule.xml';

        // Return the XML as a downloadable response
        // return Response::make($xmlString, 200)
        //     ->header('Content-Type', 'text/xml')
        //     ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    

        return Response::make($xmlString, '200')->header('Content-Type', 'text/xml');
    }

}
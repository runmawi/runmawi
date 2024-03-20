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
use GuzzleHttp\Client;

class AdminFFplayoutController extends Controller
{
    protected $baseUrl = 'http://69.197.189.34:8787';
    protected $token;

    
    public function login(Request $request)
    {
        $username = 'admin';
        $password = 'o737{@&|3TCr';

        $client = new Client();

        try {
            $response = $client->post($this->baseUrl . '/auth/login/', [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'username' => $username,
                    'password' => $password,
                ],
            ]);

            $body = $response->getBody()->getContents();
            $responseData = json_decode($body, true);
            $this->token  = $responseData['user']['token'];

            $responsechannels = $client->get($this->baseUrl .'/api/channels', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->token,
                ],
            ]);

            // Get the response body
            $bodyresponsechannels = $responsechannels->getBody()->getContents();

            $channelsresponseData = json_decode($bodyresponsechannels, true);
            $channel = (end($channelsresponseData));
            if(count($channel) > 0){
                $channelId = $channel['id'];
                $channelname = $channel['name'];
            }else{
                $channelId = 1;
                $channelname = 'Test 1';
            }
            $response = $client->get($this->baseUrl .'/api/playout/config/'.$channelId, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->token,
                ],
            ]);
            
             // Get the response body
             $bodyresponse = $response->getBody()->getContents();

             $responseData = json_decode($bodyresponse, true);

        

             $presetData = [
                "name" => "Test Present",
                "text" => "TEXT>",
                "x" => "<X>",
                "y" => "<Y>",
                "fontsize" => '24',
                "line_spacing" => '4',
                "fontcolor" => "#ffffff",
                "box" => 1,
                "boxcolor" => "#000000",
                "boxborderw" => '4',
                "alpha" => '1.0',
                "channel_id" => '12' // Convert integer to string
            ];
            
             $response = $client->post($this->baseUrl .'/api/presets/', [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $this->token,
                ],
                'json' => $presetData,
            ]);
    
            // Get the response body
            $body = $response->getBody()->getContents();
    
            // Decode JSON response
            $responseData = json_decode($body, true);
    
    

            dd($responseData);

        
            $dateString = "3-19-2024";
            $date = \DateTime::createFromFormat('m-d-Y', $dateString);
            $formattedDate = $date->format('Y-m-d');
            
            $ChannelVideoScheduler = ChannelVideoScheduler::where('channe_id', 1)
                ->where('choosed_date', "3-19-2024")
                ->orderBy('socure_order', 'ASC')
                ->join('admin_epg_channels', 'admin_epg_channels.id', '=', 'channel_videos_scheduler.channe_id')
                ->select('channel_videos_scheduler.*', 'admin_epg_channels.name')
                ->get();
            
            $playlistItems = [];
            foreach ($ChannelVideoScheduler as $item) {
                $playlistItems[] = [
                    'start' => $item->start_time,
                    'duration' => $item->duration,
                    'shuffle' => true, 
                    'path' => $item->url,
                ];
            }
            $jsonData = [
                'channel' => $channelname,
                'date' => $formattedDate,
                'playlist_items' => $playlistItems,
            ];
            
                // $playlistId = 1;
            // $response = $client->post($this->baseUrl . '/api/playlist/' . $playlistId.'/generate/'.$formattedDate, [
            //     'headers' => [
            //         'Content-Type' => 'application/json',
            //         'Authorization' => 'Bearer ' . $this->token,
            //     ],
            //     'json' => $jsonData,
            // ]);
            
            // $body = $response->getBody()->getContents();
            // $responseData = json_decode($body, true);
            
    
            // return response()->json($responseData);
            
            // dd($responseData);
    // CREATE NEW CHANNEL
            // $channelData = [
            //     'name' => 'Channel '.$channelId, 
            //     'preview_url' => $this->baseUrl.'/live/stream.m3u8',
            //     'config_path' => '/etc/ffplayout/channel'.$channelId.'.yml',
            //     'extra_extensions' => 'jpg,jpeg,png,mp4,mov,avi',
            //     'service' => 'ffplayout@channel'.$channelId.'.service',
            // ];
        

            // // Send a POST request to the channel creation endpoint
            // $responses = $client->post($this->baseUrl.'/api/channel/', [
            //     'headers' => [
            //         'Content-Type' => 'application/json',
            //         'Authorization' => 'Bearer ' . $this->token,
            //     ],
            //     'json' => $channelData,
            // ]);

            // // Get the response body
            // $bodys = $responses->getBody()->getContents();

            $responsechannels = $client->get($this->baseUrl .'/api/channels', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->token,
                ],
            ]);

            // Get the response body
            $bodyresponsechannels = $responsechannels->getBody()->getContents();
            $channelsresponseData = json_decode($bodyresponsechannels, true);

            dd($channelsresponseData);

            // $this->token = $responseData['token'];

            return response()->json($responseData);
        } catch (RequestException $e) {
            return $e->getMessage();
        }
    }

}
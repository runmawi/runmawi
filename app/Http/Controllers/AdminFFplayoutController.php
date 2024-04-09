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
    // protected $baseUrl = 'http://209.127.118.222:8787';
    
    protected $token;

    
    public function login(Request $request)
    {
        $username = 'admin';
        $password = 'o737{@&|3TCr';
        // $password = '0SgS9<28.9qo';

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
            // dd($responseData['user']['token']);
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

            // dd($responseData);

            // $filePath= 'https://localhost/staging/storage/app/public/gHLM7yEQGFKtWjpH.mp4';
            // $myfile =  fopen(storage_path('app/public/gHLM7yEQGFKtWjpH.mp4'), "r");
            //     // dd($myfile);
            // $response = $client->post($this->baseUrl . '/api/file/' . $channelId . '/upload/', [
            //     'headers' => [
            //         'Authorization' => 'Bearer ' . $this->token,
            //     ],
            //     'multipart' => [
            //         [
            //             'name' => 'file',
            //             'contents' => $myfile,
            //         ],
            //     ],
            // ]);
            

            // $body = $response->getBody()->getContents();
            // $responseData = json_decode($body, true);
            $dateString = "3-19-2024";
            $date = \DateTime::createFromFormat('m-d-Y', $dateString);
            $formattedDate = $date->format('Y-m-d');
            // $dateString = "3-19-2024";

            $date = \DateTime::createFromFormat('m-d-Y', $dateString);
            $CurrentDate = date("Y-m-d");
            // dd($current_date);
            // $CurrentDate = $current_date->format('Y-m-d');

            $ChannelVideoScheduler = ChannelVideoScheduler::where('channe_id', 1)
                ->where('choosed_date', "4-1-2024")
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


            // Reformatting the data into the desired structure
            $data = [
                'template' => [
                    'sources' => $playlistItems,
                ],
            ];

            // If you need to add additional keys like 'channel' and 'date' to the $data array, you can do it like this:
            $data['channel'] = $channelname;
            $data['date'] = $formattedDate;

            
                     
                $response = $client->delete($this->baseUrl.'/api/playlist/1/2024-04-01', [
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'Authorization' => 'Bearer ' . $this->token,
                    ],
                ]);

                // Handle response
                $body = $response->getBody()->getContents();

                // dd($body);

            $client = new Client([
                'base_uri' => $this->baseUrl .'/api/',
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $this->token,
                ],
            ]);
        
        $playlistId = 1;
        $response = $client->request('POST', "playlist/{$playlistId}/generate/2024-04-01", [
                'json' => $data,
            ]);
        
            // return $response->getBody()->getContents();
        
  
        
        // $response = generatePlaylist($playlistId, $date, $token);
        dd($response->getBody()->getContents());
        echo"<pre>"; echo $response;
                exit;
                     // Delete Playlist 
                     
                     
                // $response = $client->delete($this->baseUrl.'/api/playlist/1/2024-03-20', [
                //     'headers' => [
                //         'Content-Type' => 'application/json',
                //         'Authorization' => 'Bearer ' . $this->token,
                //     ],
                // ]);

                // // Handle response
                // $body = $response->getBody()->getContents();

                // dd($body);

                // exit;

                     // Generate Playlist 

                $playlistId = 1;
            // $response = $client->post($this->baseUrl.'/api/playlist/1/generate/'.$CurrentDate, [
            //     // $response = $client->post($this->baseUrl.'/api/playlist/1/generate/2024-03-17', [
            //         'headers' => [
            //         'Content-Type' => 'application/json',
            //         'Authorization' => 'Bearer ' . $this->token,
            //     ],
            //     // 'json' => [
            //     //     'channel' => $channelname,
            //     //     'date' => $formattedDate,
            //     //     'playlist_items' => $playlistItems,
            //     // ],
            // ]);
            
            // $body = $response->getBody()->getContents();
            // $responseData = json_decode($body, true);
            
    
            // return response()->json($responseData);
            
            dd($responseData);
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
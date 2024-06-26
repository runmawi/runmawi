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
use URL;

class HtaccessController extends Controller
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
            return view('admin.htaccess.index');

        }
    }


    public function updateHtaccess(Request $request)
    {
            
        // try {
        
            $action = $request->action == 1 ? 1 : 0;

            $htaccessPath = realpath(('.htaccess'));

            $urlWithProtocol = URl::to('/');
            $parsedUrl = parse_url($urlWithProtocol);
            $urlWithoutProtocol = $parsedUrl['host'] . (isset($parsedUrl['path']) ? $parsedUrl['path'] : '');

            $Replace_data =array(
                'yourDomain' => $urlWithoutProtocol.'/',
            );
        
            $newRule = "     RewriteRule \.(mp4|m3u8|webm|ogg)$ - [F,NC,L]";
            $newRule .= "    RewriteCond %{HTTP_REFERER} !^https?://" . $Replace_data['yourDomain'] . " [NC]\n";
        
            if($action == 1){
                $patternsAndReplacements = [
                    [
                        'pattern' => '# RewriteCond %{HTTP_REFERER} !^https?://yourDomain/ [NC]',
                        'replacement' => "      RewriteCond %{HTTP_REFERER} !^https?://" . $Replace_data['yourDomain'] . " [NC]\n",
                    ],
                    [
                        'pattern' => '# RewriteRule \.(mp4|m3u8|webm|ogg)$ - [F,NC,L]',
                        'replacement' => "      RewriteRule \.(mp4|m3u8|webm|ogg)$ - [F,NC,L]\n",
                    ],
                ];
            }else{
                $patternsAndReplacements = [
        
                    [
                        'pattern' => ' RewriteRule \.(mp4|m3u8|webm|ogg)$ - [F,NC,L]',
                        'replacement' => "     # RewriteRule \.(mp4|m3u8|webm|ogg)$ - [F,NC,L]\n",
                    ],
                ];
            }
            
        
            $htaccessLines = file($htaccessPath);
        
            $modifiedLines = array_map(function ($line) use ($patternsAndReplacements) {
                foreach ($patternsAndReplacements as $pair) {
                    $pattern = $pair['pattern'];
                    $replacement = $pair['replacement'];
        
                    if (strpos($line, $pattern) !== false) {
                        return $replacement;
                    }
                }
                return $line;
            }, $htaccessLines);
        
            file_put_contents($htaccessPath, implode('', $modifiedLines));
            return response()->json(['message'=>"true"]);

        // } catch (\Throwable $th) {
        //     return response()->json(['message'=>"false"]);
        // }
    }
}

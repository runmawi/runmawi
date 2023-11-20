<?php
namespace App\Http\Controllers;
use \Redirect as Redirect;
use Illuminate\Http\Request;
use URL;
use File;
use Auth;
use Hash;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Facades\Image;
use View;
use Validator;
use App\Http\Requests\StoreVideoRequest;
use Illuminate\Contracts\Filesystem\Filesystem;
use FFMpeg\Filters\Video\VideoFilters;
use Illuminate\Support\Str;
use App\Setting;
use GifCreator\GifCreator;
use GuzzleHttp\Client;
use GuzzleHttp\Message\Response;
use Mail;
use App\StorageSetting;
use App\User;

class AdminStorageSettingsController extends Controller
{
    public function Index()
    {
        if(!Auth::guest() && Auth::user()->package == 'Channel' ||  Auth::user()->package == 'CPP'){
            return redirect('/admin/restrict');
        }
        
        $user = User::where('id', 1)->first();
        $duedate = $user->package_ends;
        $current_date = date('Y-m-d');
        if ($current_date > $duedate)
        {
            $client = new Client();
            $url = "https://flicknexs.com/userapi/allplans";
            $params = ['userid' => 0, ];

            $headers = ['api-key' => 'k3Hy5qr73QhXrmHLXhpEh6CQ'];
            $response = $client->request('post', $url, ['json' => $params, 'headers' => $headers, 'verify' => false, ]);

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
        }
        else
        {
            $storage_settings = StorageSetting::first();
            // dd($storage_settings);
            $data = array(
                'storage_settings' => $storage_settings,
            );

            return View('admin.settings.storagesetting', $data);
        }
    }

    public function Store(Request $request)
    {
        $data = $request->all();
        // dd($data);
        $storage_settings = StorageSetting::first();

        if ($storage_settings == null)
        {
            $storage_settings = new StorageSetting;
        }

        $storage_settings->site_storage = $request->has('site_storage') ? 1 : 0 ?? 0; ;
        $storage_settings->aws_storage = $request->has('aws_storage') ? 1 : 0 ?? 0; ;
        $storage_settings->bunny_cdn_storage = $request->has('bunny_cdn_storage') ? 1 : 0 ?? 0; ;
        $storage_settings->aws_access_key = $request->aws_access_key;
        $storage_settings->aws_secret_key = $request->aws_secret_key;
        $storage_settings->aws_region = $request->aws_region;
        $storage_settings->aws_bucket = $request->aws_bucket;
        $storage_settings->aws_storage_path = $request->aws_storage_path;
        $storage_settings->aws_video_trailer_path = $request->aws_video_trailer_path;
        $storage_settings->aws_season_trailer_path = $request->aws_season_trailer_path;
        $storage_settings->aws_episode_path = $request->aws_episode_path;
        $storage_settings->aws_live_path = $request->aws_live_path;
        $storage_settings->aws_audio_path = $request->aws_audio_path;
        $storage_settings->aws_transcode_path = $request->aws_transcode_path;
        $storage_settings->site_key = $request->site_key;
        $storage_settings->site_user = $request->site_user;
        $storage_settings->site_action = $request->site_action;
        $storage_settings->site_IPSERVERAPI = $request->site_IPSERVERAPI;
        $storage_settings->bunny_cdn_region = $request->bunny_cdn_region;
        $storage_settings->bunny_cdn_storage_zone_name = $request->bunny_cdn_storage_zone_name;
        $storage_settings->bunny_cdn_hostname = $request->bunny_cdn_hostname;
        $storage_settings->bunny_cdn_ftp_access_key = $request->bunny_cdn_ftp_access_key;
        $storage_settings->bunny_cdn_access_key = $request->bunny_cdn_access_key;
        $storage_settings->bunny_cdn_file_linkend_hostname = $request->bunny_cdn_file_linkend_hostname;

        $storage_settings->save();

        // Replacing the Env file
        try
        {
            $Env_path = realpath(('.env'));

            $Replace_data = array(
                'AWS_ACCESS_KEY_ID' => $request->aws_access_key,
                'AWS_SECRET_ACCESS_KEY' => $request->aws_secret_key,
                'AWS_DEFAULT_REGION' => $request->aws_region,
                'AWS_BUCKET' => $request->aws_bucket,
            );

            file_put_contents($Env_path, implode('', array_map(function ($Env_path) use ($Replace_data)
            {
                return stristr($Env_path, 'AWS_ACCESS_KEY_ID') ? "AWS_ACCESS_KEY_ID=" . $Replace_data['AWS_ACCESS_KEY_ID'] . "\n" : $Env_path;
            }
            , file($Env_path))));

            file_put_contents($Env_path, implode('', array_map(function ($Env_path) use ($Replace_data)
            {
                return stristr($Env_path, 'AWS_SECRET_ACCESS_KEY') ? "AWS_SECRET_ACCESS_KEY=" . $Replace_data['AWS_SECRET_ACCESS_KEY'] . "\n" : $Env_path;
            }
            , file($Env_path))));

            file_put_contents($Env_path, implode('', array_map(function ($Env_path) use ($Replace_data)
            {
                return stristr($Env_path, 'AWS_DEFAULT_REGION') ? "AWS_DEFAULT_REGION=" . $Replace_data['AWS_DEFAULT_REGION'] . "\n" : $Env_path;
            }
            , file($Env_path))));

            file_put_contents($Env_path, implode('', array_map(function ($Env_path) use ($Replace_data)
            {
                return stristr($Env_path, 'AWS_BUCKET') ? "AWS_BUCKET=" . $Replace_data['AWS_BUCKET'] . "\n" : $Env_path;
            }
            , file($Env_path))));

            return Redirect::back();

        }
        catch(\Exception $e)
        {
            $Error_msg = "While ! Changing AWS Configuration Some Erro Occurs";
            $url = URL::to('/admin/storage_settings');
            echo "<script type='text/javascript'>alert('$Error_msg'); window.location.href = '$url' </script>";
        }

    }
}


<?php

namespace App\Http\Controllers;
use \App\User as User;
use \Redirect as Redirect;
use Illuminate\Http\Request;
use URL;
use File;
use App\Test as Test;
use App\Video as Video;
use App\MoviesSubtitles as MoviesSubtitles;
use App\VideoCategory as VideoCategory;
use App\VideoResolution as VideoResolution;
use App\VideosSubtitle as VideosSubtitle;
use App\Language as Language;
use App\VideoLanguage as VideoLanguage;
use App\Subtitle as Subtitle;
use App\Tag as Tag;
use Auth;
use Hash;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Facades\Image;
use View;
use Validator;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use FFMpeg\FFProbe;
use FFMpeg\Coordinate\Dimension;
use FFMpeg\Coordinate\TimeCode;
use FFMpeg\Format\Video\X264;
use App\Http\Requests\StoreVideoRequest;
use App\Jobs\ConvertVideoForStreaming;
use Illuminate\Contracts\Filesystem\Filesystem;
use FFMpeg\Filters\Video\VideoFilters;
use Illuminate\Support\Str;
use App\Artist;
use App\Videoartist;
use App\EmailSetting;
use App\EmailTemplate;
use App\Setting;
use GifCreator\GifCreator;
use GuzzleHttp\Client;
use GuzzleHttp\Message\Response;

class AdminEmailSettingsController extends Controller
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
        $email_settings = EmailSetting::find(1);
        $email_template = EmailTemplate::get();

        $data = array(
            'email_settings' => $email_settings,
            'email_template' => $email_template,
            );

        return View('admin.settings.emailsetting', $data);
        }
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $email_settings = EmailSetting::first();

        if($email_settings == null){
            $email_settings = new EmailSetting;  
        }

        $email_settings->admin_email = $request->admin_email;
        $email_settings->host_email = $request->email_host;
        $email_settings->email_port = $request->email_port;
        $email_settings->secure = $request->secure;
        $email_settings->user_email = $request->email_user;
        $email_settings->email_password = $request->password;

        $email_settings->save();

        // Replacing the Env file

        try {
            $Env_path = realpath(('.env'));

            $Replace_data =array(
                'MAIL_HOST'         =>  $request->email_host,
                'MAIL_PORT'         =>  $request->email_port,
                'MAIL_USERNAME'     =>  $request->email_user,
                'MAIL_PASSWORD'     =>  $request->password,
                'MAIL_ENCRYPTION'   =>  $request->secure,
                'MAIL_FROM_ADDRESS' =>  $request->admin_email,
            );

            file_put_contents($Env_path, implode('', 
                    array_map(function($Env_path) use ($Replace_data) {
                        return   stristr($Env_path,'MAIL_HOST') ? "MAIL_HOST=".$Replace_data['MAIL_HOST']."\n" : $Env_path;
                    }, file($Env_path))
            ));

            file_put_contents($Env_path, implode('', 
                    array_map(function($Env_path) use ($Replace_data) {
                        return   stristr($Env_path,'MAIL_PORT') ? "MAIL_PORT=".$Replace_data['MAIL_PORT']."\n" : $Env_path;
                    }, file($Env_path))
            ));

            file_put_contents($Env_path, implode('', 
                    array_map(function($Env_path) use ($Replace_data) {
                        return   stristr($Env_path,'MAIL_USERNAME') ? "MAIL_USERNAME=".$Replace_data['MAIL_USERNAME']."\n" : $Env_path;
                    }, file($Env_path))
            ));

            file_put_contents($Env_path, implode('', 
                    array_map(function($Env_path) use ($Replace_data) {
                        return   stristr($Env_path,'MAIL_PASSWORD') ? "MAIL_PASSWORD=".$Replace_data['MAIL_PASSWORD']."\n" : $Env_path;
                    }, file($Env_path))
            ));

            file_put_contents($Env_path, implode('', 
                    array_map(function($Env_path) use ($Replace_data) {
                        return   stristr($Env_path,'MAIL_ENCRYPTION') ? "MAIL_ENCRYPTION=".$Replace_data['MAIL_ENCRYPTION']."\n" : $Env_path;
                    }, file($Env_path))
            ));

            file_put_contents($Env_path, implode('', 
                    array_map(function($Env_path) use ($Replace_data) {
                        return   stristr($Env_path,'MAIL_HOST') ? "MAIL_HOST=".$Replace_data['MAIL_HOST']."\n" : $Env_path;
                    }, file($Env_path))
            ));

            file_put_contents($Env_path, implode('', 
                    array_map(function($Env_path) use ($Replace_data) {
                        return   stristr($Env_path,'MAIL_FROM_ADDRESS') ? "MAIL_FROM_ADDRESS=".$Replace_data['MAIL_FROM_ADDRESS']."\n" : $Env_path;
                    }, file($Env_path))
            ));

            return Redirect::back();

        }catch (\Exception $e) {
            $Error_msg = "While ! Changing Email Configuration Some Erro Occurs";
            $url = URL::to('/admin/email_settings');
            echo "<script type='text/javascript'>alert('$Error_msg'); window.location.href = '$url' </script>";
        }
       
    }
    

}   
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
use Mail;
use App\EmaillogsDetail;

class AdminEmailSettingsController extends Controller
{

    public function __construct()
    {
        $this->email_settings = EmailSetting::first();
    }

    public function index()
    {
        if(!Auth::guest() && Auth::user()->package == 'Channel' ||  Auth::user()->package == 'CPP'){
            return redirect('/admin/restrict');
        }
        
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
            $Error_msg = "While ! Changing Email Configuration Some Error Occurs";
            $url = URL::to('/admin/email_settings');
            echo "<script type='text/javascript'>alert('$Error_msg'); window.location.href = '$url' </script>";
        }
       
    }


    public function microsoftstore(Request $request)
    {
        $data = $request->all();
    

        $email_settings = EmailSetting::first();
        
        if($email_settings == null){
            $email_settings = new EmailSetting;  
        }

        $email_settings->microsoft365_admin_email = $request->microsoft365_admin_email;
        $email_settings->microsoft365_scope = $request->microsoft365_scope;
        $email_settings->microsoft365_tenant_id = $request->microsoft365_tenant_id;
        $email_settings->microsoft365_client_id = $request->microsoft365_client_id;
        $email_settings->microsoft365_client_secret = $request->microsoft365_client_secret;
        $email_settings->enable_microsoft365 = $request->enable_microsoft365;
        $email_settings->save();

        // Replacing the Env file

        try {
            $Env_path = realpath(('.env'));

            $Replace_data =array(
                'MICROSOFT_SENDER_EMAIL'         =>  $request->microsoft365_admin_email,
                'MICROSOFT_SCOPE'                =>  $request->microsoft365_scope,
                'MICROSOFT_TENANT_ID'            =>  $request->microsoft365_tenant_id,
                'MICROSOFT_CLIENT_ID'            =>  $request->microsoft365_client_id,
                'MICROSOFT_CLIENT_SECRET'        =>  $request->microsoft365_client_secret,
            );

            file_put_contents($Env_path, implode('', 
                    array_map(function($Env_path) use ($Replace_data) {
                        return   stristr($Env_path,'MICROSOFT_SENDER_EMAIL') ? "MICROSOFT_SENDER_EMAIL=".$Replace_data['MICROSOFT_SENDER_EMAIL']."\n" : $Env_path;
                    }, file($Env_path))
            ));

            file_put_contents($Env_path, implode('', 
                    array_map(function($Env_path) use ($Replace_data) {
                        return   stristr($Env_path,'MICROSOFT_SCOPE') ? "MICROSOFT_SCOPE=".$Replace_data['MICROSOFT_SCOPE']."\n" : $Env_path;
                    }, file($Env_path))
            ));

            file_put_contents($Env_path, implode('', 
                    array_map(function($Env_path) use ($Replace_data) {
                        return   stristr($Env_path,'MICROSOFT_TENANT_ID') ? "MICROSOFT_TENANT_ID=".$Replace_data['MICROSOFT_TENANT_ID']."\n" : $Env_path;
                    }, file($Env_path))
            ));

            file_put_contents($Env_path, implode('', 
                    array_map(function($Env_path) use ($Replace_data) {
                        return   stristr($Env_path,'MICROSOFT_CLIENT_ID') ? "MICROSOFT_CLIENT_ID=".$Replace_data['MICROSOFT_CLIENT_ID']."\n" : $Env_path;
                    }, file($Env_path))
            ));

            file_put_contents($Env_path, implode('', 
                    array_map(function($Env_path) use ($Replace_data) {
                        return   stristr($Env_path,'MICROSOFT_CLIENT_SECRET') ? "MICROSOFT_CLIENT_SECRET=".$Replace_data['MICROSOFT_CLIENT_SECRET']."\n" : $Env_path;
                    }, file($Env_path))
            ));

            return Redirect::back();

        }catch (\Exception $e) {
            $Error_msg = "While ! Changing Microsoft365 Email Configuration Some Error Occurs";
            $url = URL::to('/admin/email_settings');
            echo "<script type='text/javascript'>alert('$Error_msg'); window.location.href = '$url' </script>";
        }
       
    }


    public function Testing_EmailSettting(Request $request)
    {
        EmailSetting::where("id", 1)->update(["TestEmail" => $request->test_mail]);
        $email_template_subject =  EmailTemplate::where('id',1)->pluck('heading')->first() ;
        $email_subject  =  $email_template_subject;

        $username      = Setting::pluck('website_name')->first();
        $Testing_email = $request->test_mail;

        $data = array(
            'email' => $Testing_email,
            'username' => $username,
        );

        try {

            if ($this->email_settings->enable_microsoft365 == 1) {
                sendMicrosoftMail($Testing_email, $email_subject, 'admin.Email.TestingEmail', [
                    'Testing_Email' => $username
                ]);
            } else {
            Mail::send('admin.Email.TestingEmail', array('Testing_Email' => $username ), 
            function($message) use ($data) {
                $message->from(AdminMail(),GetWebsiteName());
                $message->to($data['email'], $data['username'])->subject('Testing the Email');
            });
        }

            $email_log      = 'Mail Sent Successfully from Testing E-Mail';
            $email_template = "0";
            $user_id = Auth::user()->id;

            Email_sent_log($user_id,$email_log,$email_template);

            return Redirect::to('admin/email_settings')->with(array('message' => 'Message has been sent successfully!', 'note_type' => 'success') );

        }catch (\Exception $e) {

            $email_log      = $e->getMessage();
            $email_template = "0";
            $user_id = Auth::user()->id;

            Email_notsent_log($user_id,$email_log,$email_template);

            $Error_msg = "Mail Configuration or Enter Mail is Incorrect !";
            $url = URL::to('/admin/email_settings');
            echo "<script type='text/javascript'>alert('$Error_msg'); window.location.href = '$url' </script>";
        }
    }

    public function email_logs(Request $request)
    {
        $data =[
            'email_logs' =>  EmaillogsDetail::latest()->paginate(10),
        ];

        return view('admin.Email.email_logs',$data);
    }

    public function email_template_testing(Request $request){

        $data = array(
            'email' => 'manikandanwebnexs@gmail.com',
            'username' => Auth::user()->name,
            'email_subject' =>  EmailTemplate::where('id',1)->pluck('heading')->first() ,
        );

        try {
            Mail::send('emails.Test', array(
                'username' => $data['username'],
                'website_name' => GetWebsiteName(),
             ), 
            function($message) use ($data) {
                $message->from(AdminMail(),GetWebsiteName());
                $message->to($data['email'], $data['username'])->subject($data['email_subject']);
            });

            $email_log      = 'Mail Sent Successfully from Welcome E-Mail';
            $email_template = "1";
            $user_id = Auth::user()->id;

            Email_sent_log($user_id,$email_log,$email_template);

        }catch (\Exception $e) {

            $email_log      = $e->getMessage();
            $email_template = "1";
            $user_id = Auth::user()->id;

            Email_notsent_log($user_id,$email_log,$email_template);

        }
    }

}   
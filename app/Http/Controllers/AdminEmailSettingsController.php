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

use GifCreator\GifCreator;


class AdminEmailSettingsController extends Controller
{
    public function index()
    {
        $email_settings = EmailSetting::find(1);
        
        $data = array(
            'email_settings' => $email_settings,
            );

        return View('admin.settings.emailsetting', $data);
    }

    public function store(Request $request)
    {
        $data = $request->all();
      
        $email_settings = EmailSetting::find(1);

        $email_settings->admin_email = $request->admin_email;
        $email_settings->host_email = $request->email_host;
        $email_settings->email_port = $request->email_port;
        $email_settings->secure = $request->secure;
        $email_settings->user_email = $request->email_user;
        $email_settings->email_password = $request->password;

        $email_settings->save();

        return Redirect::back();

    }

}   
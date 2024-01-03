<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use \App\User as User;
use \Redirect as Redirect;
use Illuminate\Http\Request;
use URL;
use App\Test as Test;
use App\Video as Video;
use App\VideoCategory as VideoCategory;
use App\VideoResolution as VideoResolution;
use App\VideosSubtitle as VideosSubtitle;
use App\Setting as Setting;
use App\Menu as Menu;
use App\Language as Language;
use App\VideoLanguage as VideoLanguage;
use App\Subtitle as Subtitle;
use App\Tag as Tag;
use App\Audio as Audio;
use App\AudioCategory as AudioCategory;
use App\Page as Page;
use Auth;
use Hash;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Facades\Image;
use View;
use Validator;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use FFMpeg\FFProbe;
use FFMpeg\Coordinate\Dimension;
use FFMpeg\Format\Video\X264;
use App\Http\Requests\StoreVideoRequest;
use App\Jobs\ConvertVideoForStreaming;
use Illuminate\Contracts\Filesystem\Filesystem;
use FFMpeg\Filters\Video\VideoFilters;
use Illuminate\Support\Str;
use App\Artist;
use App\Audioartist;
use App\AudioAlbums;
use DB;
use App\SystemSetting as SystemSetting;
use Session;
use App\CountryCode;
use App\BlockAudio;
use App\CategoryAudio;
use App\AudioLanguage;
use GuzzleHttp\Client;
use GuzzleHttp\Message\Response;
use App\InappPurchase;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use App\StorageSetting as StorageSetting;
use App\ModeratorsUser as ModeratorsUser;
use File;
use Maatwebsite\Excel\Facades\Excel;
use App\Channel;
use App\TimeZone;
use App\AdminEPGChannel;
use App\Episode as Episode;
use App\LiveStream as LiveStream;


class AdminChannelVideoController extends Controller
{
 
    public function ChannelVideoScheduler(Request $request){

        try {
           
            $Channels =  AdminEPGChannel::Select('id','name','slug','status')->get();
            $TimeZone = TimeZone::get();
            $default_time_zone = Setting::pluck('default_time_zone')->first();
            $videos = Video::where('active',1)->where('status',1)->orderBy('created_at', 'DESC')->get()->map(function ($item) {
                $item['socure_type'] = 'Video';
                return $item;
              });
            $audios = Audio::where('active',1)->where('status',1)->orderBy('created_at', 'DESC')->get()->map(function ($item) {
                $item['socure_type'] = 'Audio';
                return $item;
              });
            $episodes = Episode::where('active',1)->where('status',1)->orderBy('created_at', 'DESC')->get()->map(function ($item) {
                $item['socure_type'] = 'Episode';
                return $item;
              });
            $livestreams = LiveStream::where('active',1)->where('status',1)->orderBy('created_at', 'DESC')->get()->map(function ($item) {
                $item['socure_type'] = 'LiveStream';
                return $item;
              });

            $mergedCollection = $videos
              ->concat($audios)
              ->concat($episodes)
              ->concat($livestreams)
              ->values();
            //   dd($mergedCollection);
              

            $data = array(
            
                'Channels' => $Channels  ,
                'TimeZone' => $TimeZone  ,
                'default_time_zone' => $default_time_zone  ,
                'VideoCollection' => $mergedCollection  ,
            
            );

        } catch (\Throwable $th) {
            throw $th;
        }
        
        return view('admin.scheduler.VideoScheduler',$data);
    }


    public function FilterVideoScheduler(Request $request){

        try {
                // print_r();exit;
            $Channels =  AdminEPGChannel::Select('id','name','slug','status')->get();
            $TimeZone = TimeZone::get();
            $default_time_zone = Setting::pluck('default_time_zone')->first();
            if($request->filter == "Video"){
                $data = Video::where('active',1)->where('status',1)->orderBy('created_at', 'DESC')->get()->map(function ($item) {
                    $item['socure_type'] = 'Video';
                    return $item;
                });
            }else if($request->filter == "Audio"){ 
                $data = Audio::where('active',1)->where('status',1)->orderBy('created_at', 'DESC')->get()->map(function ($item) {
                    $item['socure_type'] = 'Audio';
                    return $item;
                });
            }else if($request->filter == "Episode"){ 
                $data = Episode::where('active',1)->where('status',1)->orderBy('created_at', 'DESC')->get()->map(function ($item) {
                    $item['socure_type'] = 'Episode';
                    return $item;
                });
            }else if($request->filter == "LiveStream"){ 
                $data = LiveStream::where('active',1)->where('status',1)->orderBy('created_at', 'DESC')->get()->map(function ($item) {
                    $item['socure_type'] = 'LiveStream';
                    return $item;
                });
            }else{
                $videos = Video::where('active',1)->where('status',1)->orderBy('created_at', 'DESC')->get()->map(function ($item) {
                    $item['socure_type'] = 'Video';
                    return $item;
                  });
                $audios = Audio::where('active',1)->where('status',1)->orderBy('created_at', 'DESC')->get()->map(function ($item) {
                    $item['socure_type'] = 'Audio';
                    return $item;
                  });
                $episodes = Episode::where('active',1)->where('status',1)->orderBy('created_at', 'DESC')->get()->map(function ($item) {
                    $item['socure_type'] = 'Episode';
                    return $item;
                  });
                $livestreams = LiveStream::where('active',1)->where('status',1)->orderBy('created_at', 'DESC')->get()->map(function ($item) {
                    $item['socure_type'] = 'LiveStream';
                    return $item;
                  });
    
                $data = $videos->concat($audios)->concat($episodes)->concat($livestreams)->values();
            }

            return  $data ;

        } catch (\Throwable $th) {
            throw $th;
        }
        
    }

}
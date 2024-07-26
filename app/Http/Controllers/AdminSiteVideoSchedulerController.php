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
use Illuminate\Pagination\LengthAwarePaginator;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use App\SiteVideoScheduler as SiteVideoScheduler;
use App\SiteTheme;
use App\VideoSchedules;
use App\DefaultSchedulerData;
use App\EPGSchedulerData;
use App\ChannelVideoScheduler;

class AdminSiteVideoSchedulerController extends Controller
{
 
    public function SiteVideoScheduler(Request $request){

        try {
           
            $Channels =  AdminEPGChannel::Select('id','name','slug','status')->get();

            // $TimeZone = TimeZone::whereIn('id',[8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25])->get();
            $TimeZone = TimeZone::get();

            $default_time_zone = Setting::pluck('default_time_zone')->first();
            
            $enable_default_timezone = SiteTheme::pluck('enable_default_timezone')->first();
            
            $utc_difference = $enable_default_timezone == 1 ? TimeZone::where('time_zone',$default_time_zone)->pluck('utc_difference')->first()  : '' ;
            
            $time_zoneid = $enable_default_timezone == 1 ? TimeZone::where('time_zone',$default_time_zone)->pluck('id')->first()  : '' ;
           
            $videos = Video::where('active',1)->where('status',1)->orderBy('created_at', 'DESC')->get()->map(function ($item) {
                $item['socure_type'] = 'Video';
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
              ->concat($episodes)
              ->concat($livestreams)
              ->values();
            //   dd($mergedCollection);
              
            $perPage = 3; // Adjust the number based on your requirement
            $currentPage = request()->get('page', 1); // Get the current page from the request or default to 1
            $paginator = new LengthAwarePaginator(
                $mergedCollection->forPage($currentPage, $perPage),
                $mergedCollection->count(),
                $perPage,
                $currentPage
            );

            $data = array(
            
                'Channels' => $Channels  ,
                'TimeZone' => $TimeZone  ,
                'default_time_zone' => $default_time_zone  ,
                'enable_default_timezone' => $enable_default_timezone  ,
                'utc_difference' => $utc_difference  ,
                // 'VideoCollection' => $paginator  ,
                'time_zoneid' => $time_zoneid  ,
                'VideoCollection' => $mergedCollection  ,
            );

        } catch (\Throwable $th) {
            throw $th;
        }
        
        return view('admin.scheduler.VideoSchedulerEpg',$data);
    }


    public function FilterVideoScheduler(Request $request){

        try {
          
            $Channels =  AdminEPGChannel::Select('id','name','slug','status')->get();

            $TimeZone = TimeZone::whereIn('id',[8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25])->get();

            $default_time_zone = Setting::pluck('default_time_zone')->first();
            if($request->filter == "Video"){
                $data = Video::where('active',1)->where('status',1)->orderBy('created_at', 'DESC')->get()->map(function ($item) {
                    $item['socure_type'] = 'Video';
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
    
                $data = $videos->concat($episodes)->concat($livestreams)->values();
            }

            return  $data ;

        } catch (\Throwable $th) {
            throw $th;
        }
        
    }

    public function ScheduledVideos(Request $request){

        try {
            return SiteVideoScheduledData($request['time'],$request['channe_id'],$request['time_zone']) ;

        } catch (\Throwable $th) {
            throw $th;
        }
        
    }
    
    public function DragDropSchedulerVideos(Request $request){

        try {

            
            $today_date_time = new \DateTime("now");
            $today_date = $today_date_time->format("n-j-Y");

            // print_r($today_date);
            // echo "<pre>";
            $choosed_date = $request->time;
            // $choosed_date_time = new \DateTime($choosed_date);
            $choosed_date_time = \DateTime::createFromFormat('m-d-Y', $choosed_date);

            $choosed_date = $choosed_date_time->format("n-j-Y");
            // print_r($choosed_date);
            // print_r($choosed_date);exit;

            $TimeZone = TimeZone::where('id',$request->time_zone)->first();
            $TimeZone_NowTime = TimeZoneScheduler($request->time_zone);
            $SocureData       = SchedulerSocureData($request->socure_type,$request->socure_id);
            $channe_id = $request->channe_id;
            $time = $request->time;
            $time_zone = $request->time_zone;
            $socure_type = $request->socure_type;
            // $choosed_date = $request->time;
            $socure_id = $request->socure_id;
            // print_r($choosed_date);
            // $choosed_date = $choosed_date->format("n-j-Y");
            // print_r($choosed_date);exit;
            // Video Scheduler Logic 
            
            if($today_date < $choosed_date){

                if(  $this->SiteVideoSchedulerWithInTimeZone($channe_id,$time,$time_zone) !== null ){

                    $SiteVideoScheduler = $this->SiteVideoSchedulerWithInTimeZone($channe_id,$time,$time_zone);

                    
                    $result = $this->VideoSchedulerWithInTimeZone($TimeZone_NowTime,$SocureData,$TimeZone,$channe_id,$time,$time_zone,$socure_type,$socure_id,$SiteVideoScheduler,$choosed_date);
         
                    if ($result !== null) {
                        if ($result == 5) {
                            return 5;
                        } else {
                            return SiteVideoScheduledData($time,$channe_id,$time_zone);
                        }
                    }else{
                        return SiteVideoScheduledData($time,$channe_id,$time_zone);

                    }

                    
                    // if($this->VideoSchedulerWithInTimeZone($TimeZone_NowTime,$SocureData,$TimeZone,$channe_id,$time,$time_zone,$socure_type,$socure_id,$SiteVideoScheduler,$choosed_date) !== null ){
                    
                    // return SiteVideoScheduledData($time,$channe_id,$time_zone);

                    // }else{

                    //     return SiteVideoScheduledData($time,$channe_id,$time_zone);
                        
                    // }

                }else if($this->SiteVideoSchedulerWithOtherTimeZone($channe_id,$time,$time_zone) !== null && $this->SiteVideoSchedulerWithOtherTimeZone($channe_id,$time,$time_zone)->isNotEmpty()){

                }else{

                    if($this->VideoSchedulerDifferentDay($TimeZone_NowTime,$SocureData,$TimeZone,$channe_id,$time,$time_zone,$socure_type,$socure_id) !== null){
                        
                        return SiteVideoScheduledData($time,$channe_id,$time_zone) ;

                    }else{

                        return SiteVideoScheduledData($time,$channe_id,$time_zone) ;
                        
                    }

                }

            }elseif($today_date == $choosed_date){
                
                if(  $this->SiteVideoSchedulerWithInTimeZone($channe_id,$time,$time_zone) !== null ){
                    
                    $SiteVideoScheduler = $this->SiteVideoSchedulerWithInTimeZone($channe_id,$time,$time_zone);

                    // if($this->VideoSchedulerWithInTimeZone($TimeZone_NowTime,$SocureData,$TimeZone,$channe_id,$time,$time_zone,$socure_type,$socure_id,$SiteVideoScheduler,$choosed_date) !== null  ){
                    //     if($this->VideoSchedulerWithInTimeZone($TimeZone_NowTime,$SocureData,$TimeZone,$channe_id,$time,$time_zone,$socure_type,$socure_id,$SiteVideoScheduler,$choosed_date) == 5 ){
                    //         return 5;
                    //     }else{
                    //         return SiteVideoScheduledData($time,$channe_id,$time_zone);
                    //     }
                    //     // print_r($this->VideoSchedulerWithInTimeZone($TimeZone_NowTime,$SocureData,$TimeZone,$channe_id,$time,$time_zone,$socure_type,$socure_id,$SiteVideoScheduler,$choosed_date));

                    // }

                    // else{

                    //     return SiteVideoScheduledData($time,$channe_id,$time_zone);
                        
                    // }

                    $result = $this->VideoSchedulerWithInTimeZone($TimeZone_NowTime,$SocureData,$TimeZone,$channe_id,$time,$time_zone,$socure_type,$socure_id,$SiteVideoScheduler,$choosed_date);
         
                    if ($result !== null) {
                        if ($result == 5) {
                            return 5;
                        } else {
                            return SiteVideoScheduledData($time,$channe_id,$time_zone);
                        }
                    }else{
                        return SiteVideoScheduledData($time,$channe_id,$time_zone);

                    }


                }
                // else if($this->SiteVideoSchedulerWithOtherTimeZone($channe_id,$time,$time_zone) !== null && $this->SiteVideoSchedulerWithOtherTimeZone($channe_id,$time,$time_zone)->isNotEmpty()){

                // }
                else{
                    
                    if($this->VideoScheduler($TimeZone_NowTime,$SocureData,$TimeZone,$channe_id,$time,$time_zone,$socure_type,$socure_id) !== null){
                        
                        return SiteVideoScheduledData($time,$channe_id,$time_zone) ;

                    }else{

                        return SiteVideoScheduledData($time,$channe_id,$time_zone) ;
                        
                    }

                }

            }else{
                return "Can't Set Video before current date" ;
            }            // return  $result ;

        } catch (\Throwable $th) {
            throw $th;
        }
        
    }


    private static function SiteVideoSchedulerWithInTimeZone($channe_id,$time,$time_zone){
    
        $SchedulerDate_time = \DateTime::createFromFormat('m-d-Y', $time);
        $time = $SchedulerDate_time->format("n-j-Y");

        try {
            $data = SiteVideoScheduler::where('channe_id',$channe_id)->where('choosed_date',$time)
            ->where('time_zone',$time_zone)->orderBy('created_at', 'DESC')->first();

            return $data ;

        } catch (\Throwable $th) {
            throw $th;
        }
    
      }

    private static function SiteVideoSchedulerWithOtherTimeZone($channe_id,$time,$time_zone){
    
        try {

            $SchedulerDate_time = \DateTime::createFromFormat('m-d-Y', $time);
            $time = $SchedulerDate_time->format("n-j-Y");

            $data = SiteVideoScheduler::where('channe_id',$channe_id)->where('choosed_date',$time)
            ->where('time_zone','!=',$time_zone)->orderBy('created_at', 'DESC')->first();

            return $data ;

        } catch (\Throwable $th) {
            throw $th;
        }

      }
    
    private static function VideoScheduler($TimeZone_NowTime,$SocureData,$TimeZone,$channe_id,$time,$time_zone,$socure_type,$socure_id){
    

        try {
        
            $current_time = strtotime($TimeZone_NowTime['current_time']);

            // Calculate the start time and end time
            $start_time = date('Y-m-d H:i:s', $current_time);
            $end_time = date('Y-m-d H:i:s', $current_time + $SocureData['seconds']);
            
            $starttime = date('H:i:s', $current_time);
            $endtime = date('H:i:s', $current_time + $SocureData['seconds']);

            $duration = gmdate('H:i:s', $SocureData['seconds']);
            
            $choosed_date = $time;

            $choosed_date_time = \DateTime::createFromFormat('m-d-Y', $choosed_date);
            $choosed_date = $choosed_date_time->format("n-j-Y");

            // Store the Scheduler

                $VideoScheduler = new SiteVideoScheduler;
                $VideoScheduler->user_id        = Auth::user()->id;
                $VideoScheduler->socure_id      = $socure_id;
                $VideoScheduler->socure_type    = $socure_type;
                $VideoScheduler->channe_id      = $channe_id;
                $VideoScheduler->content_id     = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
                $VideoScheduler->socure_order   = 1;
                $VideoScheduler->time_zone      = $time_zone;
                $VideoScheduler->choosed_date   = $choosed_date;
                $VideoScheduler->current_time   = $current_time;
                $VideoScheduler->start_time     = $starttime;
                $VideoScheduler->end_time       = $endtime;
                $VideoScheduler->socure_title   = $SocureData['socure_data']->title;
                $VideoScheduler->AM_PM_Time     = $TimeZone_NowTime['time'];
                $VideoScheduler->duration	    = $duration;
                $VideoScheduler->type           = $SocureData['type'];
                $VideoScheduler->url            = $SocureData['URL'];
                $VideoScheduler->image          = $SocureData['socure_data']->image;
                $VideoScheduler->description    = $SocureData['socure_data']->description;
                $VideoScheduler->save();

                $data = 1;
                
            return $data ;

        } catch (\Throwable $th) {
            throw $th;
        }

      }
  

      private static function VideoSchedulerWithInTimeZone($TimeZone_NowTime,$SocureData,$TimeZone,$channe_id,$time,$time_zone,$socure_type,$socure_id,$SiteVideoScheduler,$choosed_date){
    
        try {
    
            $current_time       = strtotime($TimeZone_NowTime['current_time']);
            $nowTime            = $TimeZone_NowTime['time'];
            $end_time           = $SiteVideoScheduler->end_time;
    
            $time = strtotime($time);


            $chosen_datetime = Carbon::parse($time);

            // // Check if a scheduling entry already exists for the same date
            if(existingSiteVideoSchedulerEntry($choosed_date,$channe_id,$SiteVideoScheduler->start_time) == 1){
           
                //     print_r($existingEntry);exit;

                if (strtotime($end_time) > $nowTime) {
        
                    // Calculate the start time and end time
                    $current_time = strtotime($SiteVideoScheduler->end_time);
        
                    $start_time = date('Y-m-d H:i:s', $current_time);
                    $end_time = date('Y-m-d H:i:s', $current_time + $SocureData['seconds']);
                    
                    $starttime = date('H:i:s', $current_time);
                    $endtime = date('H:i:s', $current_time + $SocureData['seconds']);
                    $TimeZone_NowTime['time'] = date('A', $current_time + $SocureData['seconds']);
                    $duration = gmdate('H:i:s', $SocureData['seconds']);

                    

                    if ($SiteVideoScheduler->AM_PM_Time == 'PM'  && $TimeZone_NowTime['time'] == 'AM') {
                        $chosen_datetime = chosen_datetime($choosed_date);
                    }else{
                        $chosen_datetime = $choosed_date;
                    }


                    if ($chosen_datetime != $choosed_date && $starttime == '00:00:00') {
                        // print_r($starttime);exit;
                        // $value = [];
                        // $value['test'] = 5;
                        return 5;
                    } else if ($chosen_datetime != $choosed_date) {
                        $chosen_datetime = $choosed_date;
                        $endtime = '24:00:00';
                        $TimeZone_NowTime['time'] = 'PM';
                    }
                    // print_r($endtime);exit;

                } else {
                // Calculate the start time and end time
                    $current_time = strtotime($TimeZone_NowTime['current_time']);
                    $start_time = date('Y-m-d H:i:s', $current_time);
                    $end_time = date('Y-m-d H:i:s', $current_time + $SocureData['seconds']);
                    
                    $starttime = date('H:i:s', $current_time);
                    $endtime = date('H:i:s', $current_time + $SocureData['seconds']);
        
                    $duration = gmdate('H:i:s', $SocureData['seconds']);

                    $chosen_datetime = $choosed_date;
                }
                    // print_r($chosen_datetime);exit;
                    // Store the Scheduler

                    $VideoScheduler = new SiteVideoScheduler;
                    $VideoScheduler->user_id        = Auth::user()->id;
                    $VideoScheduler->socure_id      = $socure_id;
                    $VideoScheduler->socure_type    = $socure_type;
                    $VideoScheduler->channe_id      = $channe_id;
                    $VideoScheduler->content_id     = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
                    $VideoScheduler->socure_order   = SiteVideoScheduler::where('channe_id',$channe_id)->where('choosed_date',$chosen_datetime)->max('socure_order') + 1;
                    $VideoScheduler->time_zone      = $time_zone;
                    $VideoScheduler->choosed_date   = $chosen_datetime;
                    $VideoScheduler->current_time   = $current_time;
                    $VideoScheduler->start_time     = $starttime;
                    $VideoScheduler->end_time       = $endtime;
                    $VideoScheduler->socure_title   = $SocureData['socure_data']->title;
                    $VideoScheduler->AM_PM_Time     = $TimeZone_NowTime['time'];
                    $VideoScheduler->duration	    = $duration;
                    $VideoScheduler->type           = $SocureData['type'];
                    $VideoScheduler->url            = $SocureData['URL'];
                    $VideoScheduler->image          = $SocureData['socure_data']->image;
                    $VideoScheduler->description    = $SocureData['socure_data']->description;
                    $VideoScheduler->save();

                    $data = 1;
                    
                return $data ;
    
                // exit;
        
            }else{
                
                $data = 0;
                        
                return $data ;
            }

        } catch (\Throwable $th) {
            throw $th;
        }
    }
    
    public function GetAllChannelDetails(Request $request){

        try {

            $channe_id = $request->channe_id;
            $time = $request->time;
            $time_zone = $request->time_zone;

            return SiteVideoScheduledData($time,$channe_id,$time_zone) ;

        } catch (\Throwable $th) {
            throw $th;
        }
        
    }

    public function GetChannelDetail(Request $request,$channelId){

        try {

            $data = SiteVideoScheduler::where('id',$channelId)->first();
            return $data ;

        } catch (\Throwable $th) {
            throw $th;
        }
        
    }


    public function SchedulerUpdateTime(Request $request){

        try {
            $editStartTime  = $request->editStartTime;
            $editEndTime    = $request->editEndTime;
            $Duration       = $request->Duration;
            $Scheduler_id   = $request->Scheduler_id;
            $channelId      = $request->channe_id;
            $SchedulerDate  = $request->SchedulerDate;

            $BeforeScheduler = SiteVideoScheduler::where('choosed_date',$SchedulerDate)->where('channe_id',$channelId)
                                ->where('id', '<', $Scheduler_id)->orderBy('created_at', 'DESC')
                                ->first();
            
            if(!empty($BeforeScheduler)){

                $socure_order = $this->GapVideoScheduler($BeforeScheduler,$editStartTime,$editEndTime);
          
            }else{
                $socure_order = null;
            }
            
            $SchedulerDate_time = \DateTime::createFromFormat('m-d-Y', $SchedulerDate);
            $SchedulerDate = $SchedulerDate_time->format("n-j-Y");

            $CurrentScheduler = SiteVideoScheduler::where('id',$Scheduler_id)->where('channe_id',$channelId)
                                ->where('choosed_date',$SchedulerDate)->first();

            // Update the start time and end time of $CurrentScheduler

                if ($CurrentScheduler) {
                    $CurrentScheduler->start_time = $editStartTime;
                    $CurrentScheduler->end_time = $editEndTime;
                    if($socure_order != null){
                        $CurrentScheduler->socure_order = $socure_order + 1;
                    }
                    $CurrentScheduler->save();
                }


                $SchedulerDate_time = \DateTime::createFromFormat('m-d-Y', $SchedulerDate);
                $SchedulerDate = $SchedulerDate_time->format("n-j-Y");

                $AfterScheduler = SiteVideoScheduler::where('channe_id',$channelId)
                            ->where('choosed_date',$SchedulerDate)
                            ->where('id', '>', $Scheduler_id)
                            ->get();
                foreach ($AfterScheduler as $scheduler) {

                    $BeforeVideoScheduler = SiteVideoScheduler::where('choosed_date',$scheduler->choosed_date)
                                    ->where('channe_id',$scheduler->channe_id)
                                    ->where('id', '<', $scheduler->id)->orderBy('created_at', 'DESC')
                                    ->first();
                    $start_time = $BeforeVideoScheduler->end_time;
                    $duration = $scheduler->duration;

                    // Convert start_time to seconds
                    list($startHours, $startMinutes, $startSeconds) = explode(':', $start_time);
                    $totalStartSeconds = ($startHours * 3600) + ($startMinutes * 60) + $startSeconds;

                    // Convert duration to seconds
                    list($durationHours, $durationMinutes, $durationSeconds) = explode(':', $duration);
                    $totalDurationSeconds = ($durationHours * 3600) + ($durationMinutes * 60) + $durationSeconds;

                    // Calculate total seconds for end time
                    $totalEndSeconds = $totalStartSeconds + $totalDurationSeconds;

                    // Convert totalEndSeconds back to H:i:s format
                    $endTime = gmdate('H:i:s', $totalEndSeconds);

                    if($scheduler->socure_id != null){
                        $scheduler->start_time = $BeforeVideoScheduler->end_time;
                        $scheduler->socure_order = $BeforeVideoScheduler->socure_order + 1;
                        $scheduler->end_time = $endTime;
                    }
                    $scheduler->save();

                }
                $data = 1 ;
            
            return $data ;

        } catch (\Throwable $th) {
            throw $th;
        }
        
    }

    private static function GapVideoScheduler($BeforeScheduler,$editStartTime,$editEndTime){
    
 
            // Store the Gap Scheduler
        
            $time1 = new \DateTime($BeforeScheduler->end_time);
            $time2 = new \DateTime($editStartTime);
            $interval = $time1->diff($time2);
            $duration = $interval->format('%H:%I:%S');

                $start_time = $BeforeScheduler->end_time;

                // Convert start_time to seconds
                list($startHours, $startMinutes, $startSeconds) = explode(':', $start_time);
                $totalStartSeconds = ($startHours * 3600) + ($startMinutes * 60) + $startSeconds;

                // Convert duration to seconds
                list($durationHours, $durationMinutes, $durationSeconds) = explode(':', $duration);
                $totalDurationSeconds = ($durationHours * 3600) + ($durationMinutes * 60) + $durationSeconds;

                // Calculate total seconds for end time
                $totalEndSeconds = $totalStartSeconds + $totalDurationSeconds;

                // Convert totalEndSeconds back to H:i:s format
                $endTime = gmdate('H:i:s', $totalEndSeconds);

                $VideoScheduler                 = new SiteVideoScheduler;
                $VideoScheduler->user_id        = Auth::user()->id;
                $VideoScheduler->socure_id      = null;
                $VideoScheduler->socure_type    = 'Gap';
                $VideoScheduler->channe_id      = $BeforeScheduler->channe_id;
                $VideoScheduler->content_id     = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
                $VideoScheduler->socure_order   = $BeforeScheduler->socure_order + 1;
                $VideoScheduler->time_zone      = $BeforeScheduler->time_zone;
                $VideoScheduler->choosed_date   = $BeforeScheduler->choosed_date;
                $VideoScheduler->current_time   = $BeforeScheduler->current_time;
                $VideoScheduler->start_time     = $BeforeScheduler->end_time;
                $VideoScheduler->end_time       = $endTime;
                $VideoScheduler->socure_title   = 'Gap';
                $VideoScheduler->AM_PM_Time     = $BeforeScheduler->AM_PM_Time;
                $VideoScheduler->duration	    = $duration;
                $VideoScheduler->type           = 'mp4';
                $VideoScheduler->url            = URL::to('/assets/video/gapvideo.mp4');
                $VideoScheduler->image          = 'default_image.webp';
                $VideoScheduler->description    = 'Gap Video Added';
                $VideoScheduler->save();

                $data = $BeforeScheduler->socure_order + 1;
            // echo"<pre>";print_r($BeforeScheduler->end_time);exit;
                
            return $data ;

    }

    public function SchedulerReSchedule(Request $request){

        try {

            $Scheduler_id   = $request->Scheduler_id;
            $channelId      = $request->channe_id;
            $SchedulerDate  = $request->SchedulerDate;
            // $SchedulerDate  = $request->SchedulerDate;
            $SchedulerDate_time = \DateTime::createFromFormat('m-d-Y', $SchedulerDate);
            $SchedulerDate = $SchedulerDate_time->format("n-j-Y");

            $CheckSameDateScheduler = SiteVideoScheduler::where('id',$Scheduler_id)
            ->where('channe_id',$channelId)
            ->where('choosed_date',$SchedulerDate)
            ->count();
            if($CheckSameDateScheduler > 0){
                return 0 ;
            }
            $CurrentScheduler = SiteVideoScheduler::where('id',$Scheduler_id)
            ->where('channe_id',$channelId)
            ->first();
            // print_r($request->all());exit;
            $data = SiteVideoScheduler::where('id',$channelId)->first();

                $VideoScheduler                 = new SiteVideoScheduler;
                $VideoScheduler->user_id        = Auth::user()->id;
                $VideoScheduler->socure_id      = $CurrentScheduler->socure_id;
                $VideoScheduler->socure_type    = $CurrentScheduler->socure_type;
                $VideoScheduler->channe_id      = $CurrentScheduler->channe_id;
                $VideoScheduler->content_id     = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
                $VideoScheduler->socure_order   = SiteVideoScheduler::where('channe_id',$channelId)->where('choosed_date',$SchedulerDate)->max('socure_order') + 1;
                $VideoScheduler->time_zone      = $CurrentScheduler->time_zone;
                $VideoScheduler->choosed_date   = $SchedulerDate;
                $VideoScheduler->current_time   = $CurrentScheduler->current_time;
                $VideoScheduler->start_time     = $CurrentScheduler->start_time;
                $VideoScheduler->end_time       = $CurrentScheduler->end_time;
                $VideoScheduler->socure_title   = $CurrentScheduler->socure_title;
                $VideoScheduler->AM_PM_Time     = $CurrentScheduler->AM_PM_Time;
                $VideoScheduler->duration	    = $CurrentScheduler->duration;
                $VideoScheduler->type           = $CurrentScheduler->type;
                $VideoScheduler->url            = $CurrentScheduler->url;
                $VideoScheduler->image          = $CurrentScheduler->image;
                $VideoScheduler->description    = $CurrentScheduler->description;
                $VideoScheduler->save();

                $data = 1;
                            
            return $data ;

        } catch (\Throwable $th) {
            throw $th;
        }
        
    }
    

    private static function VideoSchedulerDifferentDay($TimeZone_NowTime,$SocureData,$TimeZone,$channe_id,$time,$time_zone,$socure_type,$socure_id){
    

        try {

            $TimeZone_NowTime['current_time'] = "00:00:00";
            $current_time = strtotime($TimeZone_NowTime['current_time']);
        
            // Set the time to midnight

            // Calculate the start time and end time
            $start_time = date('Y-m-d H:i:s', $current_time);
            $end_time = date('Y-m-d H:i:s', $current_time + $SocureData['seconds']);
            
            $starttime = date('H:i:s', $current_time);
            $endtime = date('H:i:s', $current_time + $SocureData['seconds']);

            $duration = gmdate('H:i:s', $SocureData['seconds']);
            

            $SchedulerDate_time = \DateTime::createFromFormat('m-d-Y', $time);
            $time = $SchedulerDate_time->format("n-j-Y");

            // Store the Scheduler

                $VideoScheduler = new SiteVideoScheduler;
                $VideoScheduler->user_id        = Auth::user()->id;
                $VideoScheduler->socure_id      = $socure_id;
                $VideoScheduler->socure_type    = $socure_type;
                $VideoScheduler->channe_id      = $channe_id;
                $VideoScheduler->content_id     = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
                $VideoScheduler->socure_order   = SiteVideoScheduler::where('channe_id',$channe_id)->where('choosed_date',$time)->max('socure_order') + 1;;
                $VideoScheduler->time_zone      = $time_zone;
                $VideoScheduler->choosed_date   = $time;
                $VideoScheduler->current_time   = $current_time;
                $VideoScheduler->start_time     = $starttime;
                $VideoScheduler->end_time       = $endtime;
                $VideoScheduler->socure_title   = $SocureData['socure_data']->title;
                $VideoScheduler->AM_PM_Time     = "AM";
                $VideoScheduler->duration	    = $duration;
                $VideoScheduler->type           = $SocureData['type'];
                $VideoScheduler->url            = $SocureData['URL'];
                $VideoScheduler->image          = $SocureData['socure_data']->image;
                $VideoScheduler->description    = $SocureData['socure_data']->description;
                $VideoScheduler->save();

                $data = 1;
                
            return $data ;

        } catch (\Throwable $th) {
            throw $th;
        }

      }


      
    public function RemoveSchedulers(Request $request){

        try {

            $Scheduler_id   = $request->Scheduler_id;

            $CurrentScheduler = SiteVideoScheduler::where('id',$Scheduler_id)
            ->first();

    
            $PreviousScheduler = SiteVideoScheduler::where('channe_id',$CurrentScheduler->channe_id)
                                ->where('choosed_date',$CurrentScheduler->choosed_date)
                                ->where('id', '<', $Scheduler_id)
                                ->first();
                                
            $NextScheduler = SiteVideoScheduler::where('channe_id',$CurrentScheduler->channe_id)
                                ->where('choosed_date',$CurrentScheduler->choosed_date)
                                ->where('id', '>', $Scheduler_id)
                                ->first();

                if(!empty($PreviousScheduler) && !empty($NextScheduler)){
                    $start_time = $PreviousScheduler->end_time;
                    $duration = $NextScheduler->duration;

                    $start_time = $PreviousScheduler->end_time;
    
                    // Convert start_time to seconds
                    list($startHours, $startMinutes, $startSeconds) = explode(':', $start_time);
                    $totalStartSeconds = ($startHours * 3600) + ($startMinutes * 60) + $startSeconds;
    
                    // Convert duration to seconds
                    list($durationHours, $durationMinutes, $durationSeconds) = explode(':', $duration);
                    $totalDurationSeconds = ($durationHours * 3600) + ($durationMinutes * 60) + $durationSeconds;
    
                    // Calculate total seconds for end time
                    $totalEndSeconds = $totalStartSeconds + $totalDurationSeconds;
    
                    // Convert totalEndSeconds back to H:i:s format
                    $endTime = gmdate('H:i:s', $totalEndSeconds);

                        $NextScheduler->start_time = $PreviousScheduler->end_time;
                        $NextScheduler->socure_order = $PreviousScheduler->socure_order + 1;
                        $NextScheduler->end_time = $endTime;
                        $NextScheduler->save();

                }
                if(!empty($NextScheduler)){

                    $AfterScheduler = SiteVideoScheduler::where('channe_id',$NextScheduler->channe_id)
                                ->where('choosed_date',$NextScheduler->choosed_date)
                                ->where('id', '>', $NextScheduler->id)
                                ->get();

                    SiteVideoScheduler::where('id',$Scheduler_id)->delete();
                    $previousEndTime = $NextScheduler->end_time;

                    foreach ($AfterScheduler as $scheduler) {
                        $scheduler->start_time = $previousEndTime;
                        list($previousEndHours, $previousEndMinutes, $previousEndSeconds) = explode(':', $previousEndTime);
                        $totalPreviousEndSeconds = ($previousEndHours * 3600) + ($previousEndMinutes * 60) + $previousEndSeconds;
                    
                        $scheduler->start_time = $previousEndTime;
                        $scheduler->socure_order = $NextScheduler->socure_order;
                        
                        // Convert duration to seconds
                        list($durationHours, $durationMinutes, $durationSeconds) = explode(':', $scheduler->duration);
                        $totalDurationSeconds = ($durationHours * 3600) + ($durationMinutes * 60) + $durationSeconds;
                    
                        // Calculate total seconds for end time
                        $totalEndSeconds = $totalPreviousEndSeconds + $totalDurationSeconds;
                    
                        // Convert totalEndSeconds back to H:i:s format
                        $scheduler->end_time = gmdate('H:i:s', $totalEndSeconds);
                        $previousEndTime = $scheduler->end_time;
                    
                        $scheduler->save();

                    }
                return 1 ;
            }else{

                SiteVideoScheduler::where('id',$Scheduler_id)->delete();
                    return 1 ;
            }


        } catch (\Throwable $th) {
            throw $th;
        }
        
    }
    
    public function DefaultgenerateSchedulerXml(Request $request)
    {

        // dd($request->all());
        try {
            // $SchedulerDate_time = new \DateTime($request->time);

            $SchedulerDate_time = \DateTime::createFromFormat('m-d-Y', $request->default_date_choose);
            $time = $SchedulerDate_time->format("n-j-Y");

            // $channe_id = $request->channe_id;
            // $time_zone = $request->time_zone;
            
            $channe_id = $request->default_channel_id;
            $time_zone = $request->default_time_zone;

            // $choosen_date_time = new \DateTime($request->time);

            $choosen_date_time = \DateTime::createFromFormat('m-d-Y', $request->default_date_choose);
            $choosen_date = $choosen_date_time->format("n-j-Y");

            $file_choosed_date = $choosen_date_time->format('n_j_Y');
    
            $slug =  VideoSchedules::where('id', $channe_id)->pluck('slug')->first();
            $default_timezone = TimeZone::where('id', $time_zone)->pluck('time_zone')->first();
            $schedulers = SiteVideoScheduler::where('channe_id', $channe_id)->where('choosed_date', $choosen_date)->orderBy('current_time')->get();

            $originalTimezone = $default_timezone;
            $targetTimezones = TimeZone::get();
            $targetTimezones = TimeZone::whereIn('id',[1,2])->get();
            $targetTimezones = TimeZone::get();
    
            foreach ($targetTimezones as $target_Timezone) {
                $targetTimezone = $target_Timezone->time_zone;
                $xmlFileName = $slug . '_' . str_replace('/', '_', $targetTimezone) . '_' . $file_choosed_date . '.xml';
                $xmlFilePath = 'schedulers/' . $xmlFileName;
    
                $jsonFileName = $slug . '_' . str_replace('/', '_', $targetTimezone) . '_' . $file_choosed_date . '.json';
                $jsonFilePath = 'schedulers/' . $jsonFileName;
    
                $schedulerData = [];
                $currentDate = null;
                $totalSecondsInDay = 24 * 3600;
                $elapsedSeconds = 0;
                $previousAmPmTime = null;
    
                foreach ($schedulers as $key => $scheduler) {
                    $choosedDate = Carbon::createFromFormat('m-d-Y', $scheduler->choosed_date, $originalTimezone);
    
                    $startTime = Carbon::createFromFormat('H:i:s', $scheduler->start_time, $originalTimezone)
                        ->setTimezone($targetTimezone);
    
                    $endTime = Carbon::createFromFormat('H:i:s', $scheduler->end_time, $originalTimezone)
                        ->setTimezone($targetTimezone);
    
                    $currentTime = Carbon::createFromTimestamp($scheduler->current_time, $originalTimezone)
                        ->setTimezone($targetTimezone);
                    $currentTimeFormatted = $currentTime->format('h:i:s A');
                    $currentTimeFormatted = $currentTime->format('A');
    
                    $amPmTime = $startTime->format('A');
    
                    if (is_null($currentDate)) {
                        $currentDate = $choosedDate;
                    } else {
                        if ($previousAmPmTime === 'PM' && $amPmTime === 'AM') {
                            $currentDate = $currentDate->copy()->addDay();
                        }
                    }
    
                    $previousAmPmTime = $amPmTime;
    
                    $startSeconds = $startTime->secondsSinceMidnight();
                    $endSeconds = $endTime->secondsSinceMidnight();
    
                    if ($endSeconds < $startSeconds) {
                        $elapsedSeconds += ($totalSecondsInDay - $startSeconds) + $endSeconds;
                    } else {
                        $elapsedSeconds += ($endSeconds - $startSeconds);
                    }
    
                    if ($elapsedSeconds >= $totalSecondsInDay) {
                        $currentDate = $currentDate->copy()->addDay();
                    }
    
                    $startTimeFormatted = $startTime->format('H:i:s');
                    $endTimeFormatted = $endTime->format('H:i:s');
                    $choosedDateFormatted = $currentDate->format('m-d-Y');
    
                    DefaultSchedulerData::where('channe_id', $channe_id)->where('choosed_date', $choosedDateFormatted)->where('time_zone', $targetTimezone)->delete();

                    $schedulerData[] = [
                        // 'id' => $scheduler->id,
                        'user_id' => $scheduler->user_id,
                        'socure_id' => $scheduler->socure_id,
                        'socure_type' => $scheduler->socure_type,
                        'channe_id' => $scheduler->channe_id,
                        'content_id' => $scheduler->content_id,
                        'socure_order' => $scheduler->socure_order,
                        'time_zone' => $targetTimezone,
                        'choosed_date' => $choosedDateFormatted,
                        'current_time' => $currentTimeFormatted,
                        'start_time' => $startTimeFormatted,
                        'end_time' => $endTimeFormatted,
                        'AM_PM_Time' => $scheduler->AM_PM_Time,
                        'socure_title' => $scheduler->socure_title,
                        'duration' => $scheduler->duration,
                        'type' => $scheduler->type,
                        'url' => $scheduler->url,
                        'image' => $scheduler->image,
                        'description' => $scheduler->description,
                        'created_at' => $scheduler->created_at,
                        'updated_at' => $scheduler->updated_at
                    ];
                }
    

                    DefaultSchedulerData::insert($schedulerData);

                $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><schedulers></schedulers>');
    
                foreach ($schedulerData as $data) {
                    $scheduler = $xml->addChild('scheduler');
                    foreach ($data as $key => $value) {
                        $scheduler->addChild($key, htmlspecialchars($value));
                    }
                }
    
                $xmlContent = $xml->asXML();
                Storage::disk('local')->put($xmlFilePath, $xmlContent);
    
                $jsonContent = json_encode($schedulerData, JSON_PRETTY_PRINT);
                Storage::disk('local')->put($jsonFilePath, $jsonContent);
            }
            
            return Redirect::back()->with([
                'note' => 'XML & Json Files Generated..',
                'note_type' => 'success',
            ]);
            // return 1;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
 

    
    public function EPGgenerateSchedulerXml(Request $request)
    {

        try {

            $SchedulerDate_time = \DateTime::createFromFormat('m-d-Y', $request->epg_date_choose);
            $time = $SchedulerDate_time->format("n-j-Y");

            $channe_id = $request->epg_channel_id;
            $time_zone = $request->epg_time_zone;

            $choosen_date_time = \DateTime::createFromFormat('m-d-Y', $request->epg_date_choose);
            $choosen_date = $choosen_date_time->format("n-j-Y");

            $file_choosed_date = $choosen_date_time->format('n_j_Y');
    
            $slug =  AdminEPGChannel::where('id', $channe_id)->pluck('slug')->first();
            $default_timezone = TimeZone::where('id', $time_zone)->pluck('time_zone')->first();
            $schedulers = ChannelVideoScheduler::where('channe_id', $channe_id)->where('choosed_date', $choosen_date)->orderBy('current_time')->get();

            $originalTimezone = $default_timezone;
            $targetTimezones = TimeZone::get();
            $targetTimezones = TimeZone::whereIn('id',[1,2])->get();
            $targetTimezones = TimeZone::get();
    
            foreach ($targetTimezones as $target_Timezone) {
                $targetTimezone = $target_Timezone->time_zone;
                $xmlFileName = $slug . '_' . str_replace('/', '_', $targetTimezone) . '_' . $file_choosed_date . '.xml';
                $xmlFilePath = 'schedulers/' . $xmlFileName;
    
                $jsonFileName = $slug . '_' . str_replace('/', '_', $targetTimezone) . '_' . $file_choosed_date . '.json';
                $jsonFilePath = 'schedulers/' . $jsonFileName;
    
                $schedulerData = [];
                $currentDate = null;
                $totalSecondsInDay = 24 * 3600;
                $elapsedSeconds = 0;
                $previousAmPmTime = null;
    
                foreach ($schedulers as $key => $scheduler) {
                    $choosedDate = Carbon::createFromFormat('m-d-Y', $scheduler->choosed_date, $originalTimezone);
    
                    $startTime = Carbon::createFromFormat('H:i:s', $scheduler->start_time, $originalTimezone)
                        ->setTimezone($targetTimezone);
    
                    $endTime = Carbon::createFromFormat('H:i:s', $scheduler->end_time, $originalTimezone)
                        ->setTimezone($targetTimezone);
    
                    $currentTime = Carbon::createFromTimestamp($scheduler->current_time, $originalTimezone)
                        ->setTimezone($targetTimezone);
                    $currentTimeFormatted = $currentTime->format('h:i:s A');
                    $currentTimeFormatted = $currentTime->format('A');
    
                    $amPmTime = $startTime->format('A');
    
                    if (is_null($currentDate)) {
                        $currentDate = $choosedDate;
                    } else {
                        if ($previousAmPmTime === 'PM' && $amPmTime === 'AM') {
                            $currentDate = $currentDate->copy()->addDay();
                        }
                    }
    
                    $previousAmPmTime = $amPmTime;
    
                    $startSeconds = $startTime->secondsSinceMidnight();
                    $endSeconds = $endTime->secondsSinceMidnight();
    
                    if ($endSeconds < $startSeconds) {
                        $elapsedSeconds += ($totalSecondsInDay - $startSeconds) + $endSeconds;
                    } else {
                        $elapsedSeconds += ($endSeconds - $startSeconds);
                    }
    
                    if ($elapsedSeconds >= $totalSecondsInDay) {
                        $currentDate = $currentDate->copy()->addDay();
                    }
    
                    $startTimeFormatted = $startTime->format('H:i:s');
                    $endTimeFormatted = $endTime->format('H:i:s');
                    $choosedDateFormatted = $currentDate->format('m-d-Y');
    
                    EPGSchedulerData::where('channe_id', $channe_id)->where('choosed_date', $choosedDateFormatted)->where('time_zone', $targetTimezone)->delete();

                    $schedulerData[] = [
                        // 'id' => $scheduler->id,
                        'user_id' => $scheduler->user_id,
                        'socure_id' => $scheduler->socure_id,
                        'socure_type' => $scheduler->socure_type,
                        'channe_id' => $scheduler->channe_id,
                        'content_id' => $scheduler->content_id,
                        'socure_order' => $scheduler->socure_order,
                        'time_zone' => $targetTimezone,
                        'choosed_date' => $choosedDateFormatted,
                        'current_time' => $currentTimeFormatted,
                        'start_time' => $startTimeFormatted,
                        'end_time' => $endTimeFormatted,
                        'AM_PM_Time' => $scheduler->AM_PM_Time,
                        'socure_title' => $scheduler->socure_title,
                        'duration' => $scheduler->duration,
                        'type' => $scheduler->type,
                        'url' => $scheduler->url,
                        'image' => $scheduler->image,
                        'description' => $scheduler->description,
                        'created_at' => $scheduler->created_at,
                        'updated_at' => $scheduler->updated_at
                    ];
                }
    

                    EPGSchedulerData::insert($schedulerData);

                $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><schedulers></schedulers>');
    
                foreach ($schedulerData as $data) {
                    $scheduler = $xml->addChild('scheduler');
                    foreach ($data as $key => $value) {
                        $scheduler->addChild($key, htmlspecialchars($value));
                    }
                }
    
                $xmlContent = $xml->asXML();
                Storage::disk('local')->put($xmlFilePath, $xmlContent);
    
                $jsonContent = json_encode($schedulerData, JSON_PRETTY_PRINT);
                Storage::disk('local')->put($jsonFilePath, $jsonContent);
            }
            
            return Redirect::back()->with([
                'note' => 'XML & Json Files Generated..',
                'note_type' => 'success',
            ]);
            // return 1;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
 
    // Without Storing Data in DB only Create XML and Json


    public function ActualDefaultgenerateSchedulerXml(Request $request)
    {
        try {
            
            $SchedulerDate_time = new \DateTime($request->time);
            $time = $SchedulerDate_time->format("j-n-Y");
            $channe_id = $request->channe_id;
            $time_zone = $request->time_zone;

            $choosen_date_time = new \DateTime($request->time);
            $choosen_date = $choosen_date_time->format("n-j-Y");
            $file_choosed_date = $choosen_date_time->format('n_j_Y');

            $slug =  VideoSchedules::where('id',$channe_id)->pluck('slug')->first();
            

            $default_timezone = TimeZone::where('id',$time_zone)->pluck('time_zone')->first();

            $schedulers = SiteVideoScheduler::where('channe_id',$channe_id)->where('choosed_date',$choosen_date)->orderBy('current_time')->get();


            $originalTimezone = $default_timezone;
           
            $targetTimezones = TimeZone::get();

            foreach ($targetTimezones as $target_Timezone) {

                $targetTimezone = $target_Timezone->time_zone;

                $xmlFileName = $slug . '_' . str_replace('/', '_', $targetTimezone) . '_' . $file_choosed_date . '.xml';
                $xmlFilePath = 'schedulers/' . $xmlFileName;

                $jsonFileName = $slug . '_' . str_replace('/', '_', $targetTimezone) . '_' . $file_choosed_date . '.json';
                $jsonFilePath = 'schedulers/' . $jsonFileName;

                $schedulerData = [];
                $currentDate = null;
                $totalSecondsInDay = 24 * 3600;
                $elapsedSeconds = 0;
                $previousAmPmTime = null;

                foreach ($schedulers as $key => $scheduler) {
                    $choosedDate = Carbon::createFromFormat('m-d-Y', $scheduler->choosed_date, $originalTimezone);

                    $startTime = Carbon::createFromFormat('H:i:s', $scheduler->start_time, $originalTimezone)
                        ->setTimezone($targetTimezone);

                    $endTime = Carbon::createFromFormat('H:i:s', $scheduler->end_time, $originalTimezone)
                        ->setTimezone($targetTimezone);

                    $currentTime = Carbon::createFromTimestamp($scheduler->current_time, $originalTimezone)
                        ->setTimezone($targetTimezone);
                    $currentTimeFormatted = $currentTime->format('h:i:s A');
                    $currentTimeFormatted = $currentTime->format('A');

                    $amPmTime = $startTime->format('A');

                    if (is_null($currentDate)) {
                        $currentDate = $choosedDate;
                    } else {
                        if ($previousAmPmTime === 'PM' && $amPmTime === 'AM') {
                            $currentDate = $currentDate->copy()->addDay();
                        }
                    }

                    $previousAmPmTime = $amPmTime;

                    $startSeconds = $startTime->secondsSinceMidnight();
                    $endSeconds = $endTime->secondsSinceMidnight();

                    if ($endSeconds < $startSeconds) {
                        $elapsedSeconds += ($totalSecondsInDay - $startSeconds) + $endSeconds;
                    } else {
                        $elapsedSeconds += ($endSeconds - $startSeconds);
                    }

                    if ($elapsedSeconds >= $totalSecondsInDay) {
                        $currentDate = $currentDate->copy()->addDay();
                    }

                    $startTimeFormatted = $startTime->format('H:i:s');
                    $endTimeFormatted = $endTime->format('H:i:s');
                    $choosedDateFormatted = $currentDate->format('m-d-Y');

                    $schedulerData[] = [
                        'id' => $scheduler->id,
                        'user_id' => $scheduler->user_id,
                        'socure_id' => $scheduler->socure_id,
                        'socure_type' => $scheduler->socure_type,
                        'channe_id' => $scheduler->channe_id,
                        'content_id' => $scheduler->content_id,
                        'socure_order' => $scheduler->socure_order,
                        'time_zone' => $targetTimezone,
                        'choosed_date' => $choosedDateFormatted,
                        'current_time' => $currentTimeFormatted,
                        'start_time' => $startTimeFormatted,
                        'end_time' => $endTimeFormatted,
                        'AM_PM_Time' => $scheduler->AM_PM_Time,
                        'socure_title' => $scheduler->socure_title,
                        'duration' => $scheduler->duration,
                        'type' => $scheduler->type,
                        'url' => $scheduler->url,
                        'image' => $scheduler->image,
                        'description' => $scheduler->description,
                        'created_at' => $scheduler->created_at,
                        'updated_at' => $scheduler->updated_at
                    ];
                }

                $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><schedulers></schedulers>');

                foreach ($schedulerData as $data) {
                    $scheduler = $xml->addChild('scheduler');
                    foreach ($data as $key => $value) {
                        $scheduler->addChild($key, htmlspecialchars($value));
                    }
                }

                $xmlContent = $xml->asXML();

                Storage::disk('local')->put($xmlFilePath, $xmlContent);

                $jsonContent = json_encode($schedulerData, JSON_PRETTY_PRINT);

                Storage::disk('local')->put($jsonFilePath, $jsonContent);
            }
            
            return 1;

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    
    // Test generateSchedulerXml 


    public function generateSchedulerXml()
    {

        $slug = 'Test_Demo';
        $VideoSchedules =  VideoSchedules::where('slug',$slug)->first();

        $today_date_time = new \DateTime("now");
        $today_date = $today_date_time->format("n-j-Y");
        $file_choosed_date = $today_date_time->format('n_j_Y');
        // dd($choosed_date);

        $schedulers = DB::table('site_videos_scheduler')->where('channe_id',$VideoSchedules->id)->where('choosed_date',$today_date)->orderBy('current_time')->get();
        // dd($schedulers);
        // Define the timezones
        $originalTimezone = 'America/Tijuana';
        $targetTimezone = 'Europe/Paris';
        
        $schedulerData = [];
        $currentDate = null;
        $totalSecondsInDay = 24 * 3600; 
        $elapsedSeconds = 0;
        $previousAmPmTime = null;
        
        foreach ($schedulers as $key => $scheduler) {

            $choosedDate = Carbon::createFromFormat('m-d-Y', $scheduler->choosed_date, $originalTimezone);
        
            $startTime = Carbon::createFromFormat('H:i:s', $scheduler->start_time, $originalTimezone)
                              ->setTimezone($targetTimezone);
        
            $endTime = Carbon::createFromFormat('H:i:s', $scheduler->end_time, $originalTimezone)
                            ->setTimezone($targetTimezone);
        
            $currentTime = Carbon::createFromTimestamp($scheduler->current_time, $originalTimezone)
                                 ->setTimezone($targetTimezone);
            $currentTimeFormatted = $currentTime->format('h:i:s A');
            $currentTimeFormatted = $currentTime->format('A');
        
            $amPmTime = $startTime->format('A');
        
            if (is_null($currentDate)) {
                $currentDate = $choosedDate;
            } else {
                if ($previousAmPmTime === 'PM' && $amPmTime === 'AM') {
                    $currentDate = $currentDate->copy()->addDay();
                }
            }
        
            $previousAmPmTime = $amPmTime;
        
            $startSeconds = $startTime->secondsSinceMidnight();
            $endSeconds = $endTime->secondsSinceMidnight();
        
            if ($endSeconds < $startSeconds) {
                $elapsedSeconds += ($totalSecondsInDay - $startSeconds) + $endSeconds;
            } else {
                $elapsedSeconds += ($endSeconds - $startSeconds);
            }
        
            if ($elapsedSeconds >= $totalSecondsInDay) {
                $currentDate = $currentDate->copy()->addDay();
            }
        
            $startTimeFormatted = $startTime->format('H:i:s');
            $endTimeFormatted = $endTime->format('H:i:s');
            $choosedDateFormatted = $currentDate->format('m-d-Y');
        
            $schedulerData[] = [
                'id' => $scheduler->id,
                'user_id' => $scheduler->user_id,
                'socure_id' => $scheduler->socure_id,
                'socure_type' => $scheduler->socure_type,
                'channe_id' => $scheduler->channe_id,
                'content_id' => $scheduler->content_id,
                'socure_order' => $scheduler->socure_order,
                'time_zone' => $targetTimezone,
                'choosed_date' => $choosedDateFormatted,
                'current_time' => $currentTimeFormatted,
                'start_time' => $startTimeFormatted,
                'end_time' => $endTimeFormatted,
                'AM_PM_Time' => $scheduler->AM_PM_Time,
                'socure_title' => $scheduler->socure_title,
                'duration' => $scheduler->duration,
                'type' => $scheduler->type,
                'url' => $scheduler->url,
                'image' => $scheduler->image,
                'description' => $scheduler->description,
                'created_at' => $scheduler->created_at,
                'updated_at' => $scheduler->updated_at
            ];
        }
        
        // Generate XML file
        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><schedulers></schedulers>');
        
        foreach ($schedulerData as $data) {
            $scheduler = $xml->addChild('scheduler');
            foreach ($data as $key => $value) {
                $scheduler->addChild($key, htmlspecialchars($value));
            }
        }
        
        $xmlContent = $xml->asXML();

        $target_Timezone = str_replace('/', '_', $targetTimezone);
        // Define the file name and path for XML
        $xmlFileName = $slug.'_'.$target_Timezone .'_' . now()->format('Y_m_d') . '.xml';
        $xmlFilePath = 'schedulers/' . $xmlFileName;
        
        // Store XML in the storage path
        Storage::disk('local')->put($xmlFilePath, $xmlContent);

        // Generate JSON file
        $jsonContent = json_encode($schedulerData, JSON_PRETTY_PRINT);


        // Define the file name and path for JSON
        $jsonFileName = $slug.'_'.$target_Timezone .'_' . now()->format('Y_m_d') . '.json';
        $jsonFilePath = 'schedulers/' . $jsonFileName;
        
        // Store JSON in the storage path
        Storage::disk('local')->put($jsonFilePath, $jsonContent);

        
        return response($xml->asXML(), 200)
        ->header('Content-Type', 'application/xml');
        return response()->json(['message' => 'XML generated and stored successfully.', 'file' => $filePath]);
        
        return response($xml->asXML(), 200)
                    ->header('Content-Type', 'application/xml');
    }

  

}
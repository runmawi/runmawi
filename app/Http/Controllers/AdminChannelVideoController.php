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
use App\ChannelVideoScheduler as ChannelVideoScheduler;

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
                // 'VideoCollection' => $paginator  ,
                'VideoCollection' => $mergedCollection  ,
            );

        } catch (\Throwable $th) {
            throw $th;
        }
        
        return view('admin.scheduler.VideoScheduler',$data);
    }


    public function FilterVideoScheduler(Request $request){

        try {
          
            $Channels =  AdminEPGChannel::Select('id','name','slug','status')->get();
            $TimeZone = TimeZone::get();
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
            return VideoScheduledData($request['time'],$request['channe_id'],$request['time_zone']) ;

        } catch (\Throwable $th) {
            throw $th;
        }
        
    }
    
    public function DragDropSchedulerVideos(Request $request){

        try {

            $TimeZone = TimeZone::where('id',$request->time_zone)->first();
            $TimeZone_NowTime = TimeZoneScheduler($request->time_zone);
            $SocureData       = SchedulerSocureData($request->socure_type,$request->socure_id);
            $channe_id = $request->channe_id;
            $time = $request->time;
            $time_zone = $request->time_zone;
            $socure_type = $request->socure_type;
            $choosed_date = $request->time;
            $socure_id = $request->socure_id;
            // $ChannelVideoScheduler = ChannelVideoScheduler($request->channe_id,$request->time,$request->time_zone);
            // $ChannelVideoScheduler = ChannelVideoSchedulerWithTimeZone($request->channe_id,$request->time,$request->time_zone);
            
            // print_r($this->ChannelVideoSchedulerWithInTimeZone($channe_id,$time,$time_zone));exit;

            // Video Scheduler Logic 

            $today_date_time = new \DateTime("now");
            $today_date = $today_date_time->format("n-j-Y");

            if($today_date < $choosed_date){
                
                if(  $this->ChannelVideoSchedulerWithInTimeZone($channe_id,$time,$time_zone) !== null ){
                    $ChannelVideoScheduler = $this->ChannelVideoSchedulerWithInTimeZone($channe_id,$time,$time_zone);

                    if($this->VideoSchedulerWithInTimeZone($TimeZone_NowTime,$SocureData,$TimeZone,$channe_id,$time,$time_zone,$socure_type,$socure_id,$ChannelVideoScheduler,$choosed_date) !== null ){
                    
                    return VideoScheduledData($time,$channe_id,$time_zone);

                    }else{

                        return VideoScheduledData($time,$channe_id,$time_zone);
                        
                    }

                }else if($this->ChannelVideoSchedulerWithOtherTimeZone($channe_id,$time,$time_zone) !== null && $this->ChannelVideoSchedulerWithOtherTimeZone($channe_id,$time,$time_zone)->isNotEmpty()){

                }else{
                    if($this->VideoSchedulerDifferentDay($TimeZone_NowTime,$SocureData,$TimeZone,$channe_id,$time,$time_zone,$socure_type,$socure_id) !== null){
                        
                        return VideoScheduledData($time,$channe_id,$time_zone) ;

                    }else{

                        return VideoScheduledData($time,$channe_id,$time_zone) ;
                        
                    }

                }

            }elseif($today_date == $choosed_date){
                

                if(  $this->ChannelVideoSchedulerWithInTimeZone($channe_id,$time,$time_zone) !== null ){
                    $ChannelVideoScheduler = $this->ChannelVideoSchedulerWithInTimeZone($channe_id,$time,$time_zone);

                    if($this->VideoSchedulerWithInTimeZone($TimeZone_NowTime,$SocureData,$TimeZone,$channe_id,$time,$time_zone,$socure_type,$socure_id,$ChannelVideoScheduler,$choosed_date) !== null ){
                    
                        // print_r($this->ChannelVideoSchedulerWithInTimeZone($channe_id,$time,$time_zone));

                    return VideoScheduledData($time,$channe_id,$time_zone);

                    }else{

                        return VideoScheduledData($time,$channe_id,$time_zone);
                        
                    }

                }else if($this->ChannelVideoSchedulerWithOtherTimeZone($channe_id,$time,$time_zone) !== null && $this->ChannelVideoSchedulerWithOtherTimeZone($channe_id,$time,$time_zone)->isNotEmpty()){

                }else{
                    if($this->VideoScheduler($TimeZone_NowTime,$SocureData,$TimeZone,$channe_id,$time,$time_zone,$socure_type,$socure_id) !== null){
                        
                        return VideoScheduledData($time,$channe_id,$time_zone) ;

                    }else{

                        return VideoScheduledData($time,$channe_id,$time_zone) ;
                        
                    }

                }

            }else{
                return "Can't Set Video before current date" ;
            }            // return  $result ;

        } catch (\Throwable $th) {
            throw $th;
        }
        
    }


    private static function ChannelVideoSchedulerWithInTimeZone($channe_id,$time,$time_zone){
    
        try {

            $data = ChannelVideoScheduler::where('channe_id',$channe_id)->where('choosed_date',$time)
            ->where('time_zone',$time_zone)->orderBy('created_at', 'DESC')->first();

            return $data ;

        } catch (\Throwable $th) {
            throw $th;
        }
    
      }

    private static function ChannelVideoSchedulerWithOtherTimeZone($channe_id,$time,$time_zone){
    
        try {

            $data = ChannelVideoScheduler::where('channe_id',$channe_id)->where('choosed_date',$time)
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
            

            // Store the Scheduler

                $VideoScheduler = new ChannelVideoScheduler;
                $VideoScheduler->user_id        = Auth::user()->id;
                $VideoScheduler->socure_id      = $socure_id;
                $VideoScheduler->socure_type    = $socure_type;
                $VideoScheduler->channe_id      = $channe_id;
                $VideoScheduler->content_id     = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
                $VideoScheduler->socure_order   = 1;
                $VideoScheduler->time_zone      = $time_zone;
                $VideoScheduler->choosed_date   = $time;
                $VideoScheduler->current_time   = $current_time;
                $VideoScheduler->start_time     = $starttime;
                $VideoScheduler->end_time       = $endtime;
                $VideoScheduler->socure_title   = $SocureData['socure_data']->title;
                $VideoScheduler->AM_PM_Time     = $TimeZone_NowTime['time'];
                $VideoScheduler->duration	    = $duration;
                $VideoScheduler->type           = $SocureData['type'];
                $VideoScheduler->url            = $SocureData['URL'];
                $VideoScheduler->save();

                $data = 1;
                
            return $data ;

        } catch (\Throwable $th) {
            throw $th;
        }

      }
  

      private static function VideoSchedulerWithInTimeZone($TimeZone_NowTime,$SocureData,$TimeZone,$channe_id,$time,$time_zone,$socure_type,$socure_id,$ChannelVideoScheduler,$choosed_date){
    
        try {
    
            $current_time       = strtotime($TimeZone_NowTime['current_time']);
            $nowTime            = $TimeZone_NowTime['time'];
            $end_time           = $ChannelVideoScheduler->end_time;
    
            $time = strtotime($time);


            $chosen_datetime = Carbon::parse($time);

            // // Check if a scheduling entry already exists for the same date
            if(existingVideoSchedulerEntry($choosed_date,$channe_id,$ChannelVideoScheduler->start_time) == 1){
           
                //     print_r($existingEntry);exit;

                if (strtotime($end_time) > $nowTime) {
        
                    // Calculate the start time and end time
                    $current_time = strtotime($ChannelVideoScheduler->end_time);
        
                    $start_time = date('Y-m-d H:i:s', $current_time);
                    $end_time = date('Y-m-d H:i:s', $current_time + $SocureData['seconds']);
                    
                    $starttime = date('H:i:s', $current_time);
                    $endtime = date('H:i:s', $current_time + $SocureData['seconds']);
                    $TimeZone_NowTime['time'] = date('A', $current_time + $SocureData['seconds']);
                    $duration = gmdate('H:i:s', $SocureData['seconds']);
                    // print_r($endtime);exit;
                    if ($ChannelVideoScheduler->AM_PM_Time == 'PM'  && $TimeZone_NowTime['time'] == 'AM') {
                        $chosen_datetime = chosen_datetime($choosed_date);
                        
                    }else{
                        $chosen_datetime = $choosed_date;
                    }

        
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

                    // Store the Scheduler

                    $VideoScheduler = new ChannelVideoScheduler;
                    $VideoScheduler->user_id        = Auth::user()->id;
                    $VideoScheduler->socure_id      = $socure_id;
                    $VideoScheduler->socure_type    = $socure_type;
                    $VideoScheduler->channe_id      = $channe_id;
                    $VideoScheduler->content_id     = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
                    $VideoScheduler->socure_order   = ChannelVideoScheduler::where('channe_id',$channe_id)->where('choosed_date',$time)->max('socure_order') + 1;
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

            return VideoScheduledData($time,$channe_id,$time_zone) ;

        } catch (\Throwable $th) {
            throw $th;
        }
        
    }

    public function GetChannelDetail(Request $request,$channelId){

        try {

            $data = ChannelVideoScheduler::where('id',$channelId)->first();
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

            $BeforeScheduler = ChannelVideoScheduler::where('choosed_date',$SchedulerDate)->where('channe_id',$channelId)
                                ->where('id', '<', $Scheduler_id)->orderBy('created_at', 'DESC')
                                ->first();
            
            if(!empty($BeforeScheduler)){

                $socure_order = $this->GapVideoScheduler($BeforeScheduler,$editStartTime,$editEndTime);
          
            }else{
                $socure_order = null;
            }

            $CurrentScheduler = ChannelVideoScheduler::where('id',$Scheduler_id)->where('channe_id',$channelId)
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
           
                $AfterScheduler = ChannelVideoScheduler::where('channe_id',$channelId)
                            ->where('choosed_date',$SchedulerDate)
                            ->where('id', '>', $Scheduler_id)
                            ->get();
                foreach ($AfterScheduler as $scheduler) {

                    $BeforeVideoScheduler = ChannelVideoScheduler::where('choosed_date',$scheduler->choosed_date)
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

                $VideoScheduler                 = new ChannelVideoScheduler;
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
                $VideoScheduler->type           = 'Gap';
                $VideoScheduler->url            = 'Gap';
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

            $CheckSameDateScheduler = ChannelVideoScheduler::where('id',$Scheduler_id)
            ->where('channe_id',$channelId)
            ->where('choosed_date',$SchedulerDate)
            ->count();
            if($CheckSameDateScheduler > 0){
                return 0 ;
            }
            $CurrentScheduler = ChannelVideoScheduler::where('id',$Scheduler_id)
            ->where('channe_id',$channelId)
            ->first();
            // print_r($request->all());exit;
            $data = ChannelVideoScheduler::where('id',$channelId)->first();

                $VideoScheduler                 = new ChannelVideoScheduler;
                $VideoScheduler->user_id        = Auth::user()->id;
                $VideoScheduler->socure_id      = $CurrentScheduler->socure_id;
                $VideoScheduler->socure_type    = $CurrentScheduler->socure_type;
                $VideoScheduler->channe_id      = $CurrentScheduler->channe_id;
                $VideoScheduler->content_id     = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
                $VideoScheduler->socure_order   = ChannelVideoScheduler::where('channe_id',$channelId)->where('choosed_date',$SchedulerDate)->max('socure_order') + 1;
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
            

            // Store the Scheduler

                $VideoScheduler = new ChannelVideoScheduler;
                $VideoScheduler->user_id        = Auth::user()->id;
                $VideoScheduler->socure_id      = $socure_id;
                $VideoScheduler->socure_type    = $socure_type;
                $VideoScheduler->channe_id      = $channe_id;
                $VideoScheduler->content_id     = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
                $VideoScheduler->socure_order   = 1;
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
                $VideoScheduler->save();

                $data = 1;
                
            return $data ;

        } catch (\Throwable $th) {
            throw $th;
        }

      }
  

}
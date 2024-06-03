<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use App\AdminEPGChannel;
use App\ChannelVideoScheduler;
use App\HomeSetting;
use App\User;
use App\TimeZone;
use Carbon\Carbon;
use App\OrderHomeSetting;
use View;
use Theme;

class ChannelVideoSchedulerController extends Controller
{
    public function __construct()
    {
        $this->Theme = HomeSetting::pluck('theme_choosen')->first();
        Theme::uses($this->Theme);
    }

    public function index(Request $request)
    {

        $channel_video_scheduler_id = AdminEPGChannel::where('slug', $request->slug)->pluck('id')->first();

        $AdminEPGChannel = AdminEPGChannel::where('status', 1)->where('id', $channel_video_scheduler_id)->get()

            ->map(function ($item) {

                $item['image_url'] = $item->image != null ? URL::to('public/uploads/EPG-Channel/' . $item->image) : default_vertical_image_url();

                $item['Player_image_url'] = $item->player_image != null ? URL::to('public/uploads/EPG-Channel/' . $item->player_image) : default_horizontal_image_url();

                $item['Logo_url'] = $item->logo != null ? URL::to('public/uploads/EPG-Channel/' . $item->logo) : default_vertical_image_url();

                $item['ChannelVideoScheduler'] = ChannelVideoScheduler::where('channe_id', $item->id)
                    ->where('choosed_date', '=', Carbon::today()->format('n-j-Y'))
                    ->where('start_time','>',Carbon::now()->toTimeString())
                    ->orderBy('start_time')
                    ->get()
                    ->map(function ($item) {

                        switch (true) {

                            case $item['url'] != null && pathinfo($item['url'], PATHINFO_EXTENSION) == 'mp4':
                                $item['video_url'] = $item->url;
                                $item['mimeType'] = 'video/mp4';
                            break;

                            case $item['url'] != null && pathinfo($item['url'], PATHINFO_EXTENSION) == 'm3u8':
                                $item['video_url'] = $item->url;
                                $item['mimeType'] = 'application/x-mpegURL';
                            break;

                            default:
                                $item['video_url'] = null;
                                $item['mimeType'] = null;
                            break;
                        }

                        $item['videos_list'] = [
                            'url' => $item['video_url'],
                            'mimeType' => $item['mimeType'],
                        ];

                        return $item;
                    });
                return $item;
            })
            ->first();

        $data = [ 'AdminEPGChannel' => $AdminEPGChannel ];

        return Theme::view('video-js-Player.Channel-Video-Scheduler.videos', $data);
    }

    public function page_list(Request $request)
    {
    //    try 
    //     {

            $current_timezone = current_timezone();
            $carbon_now = Carbon::now( $current_timezone ); 
            $carbon_current_time =  $carbon_now->format('H:i:s');
            $carbon_today =  $carbon_now->format('n-j-Y');
            $default_vertical_image_url = default_vertical_image_url() ;
            $default_horizontal_image_url = default_horizontal_image_url();
                
            $order_settings = OrderHomeSetting::orderBy('order_id', 'asc')->pluck('video_name')->toArray();  
            $order_settings_list = OrderHomeSetting::get(); 

            $ChannelVideoScheduler =  AdminEPGChannel::where('status',1)->limit(15)->get()->map(function ($item) use ($default_vertical_image_url ,$default_horizontal_image_url , $carbon_now , $carbon_today , $current_timezone) {
                        
                        $item['image_url'] = $item->image != null ? URL::to('public/uploads/EPG-Channel/'.$item->image ) : $default_vertical_image_url ;
                        $item['Player_image_url'] = $item->player_image != null ?  URL::to('public/uploads/EPG-Channel/'.$item->player_image ) : $default_horizontal_image_url;
                        $item['Logo_url'] = $item->logo != null ?  URL::to('public/uploads/EPG-Channel/'.$item->logo ) : $default_vertical_image_url;
                                                            
                        $item['ChannelVideoScheduler_current_video_details']  =  ChannelVideoScheduler::where('channe_id',$item->id)->where('choosed_date' , $carbon_today )
                                                                                    ->limit(15)->get()->map(function ($item) use ($carbon_now , $current_timezone) {

                                                                                        $TimeZone   = TimeZone::where('id',$item->time_zone)->first();

                                                                                        $converted_start_time = Carbon::createFromFormat('m-d-Y H:i:s', $item->choosed_date . $item->start_time, $TimeZone->time_zone )
                                                                                                                                        ->copy()->tz( $current_timezone );

                                                                                        $converted_end_time = Carbon::createFromFormat('m-d-Y H:i:s', $item->choosed_date . $item->end_time, $TimeZone->time_zone )
                                                                                                                                        ->copy()->tz( $current_timezone );

                                                                                        if ($carbon_now->between($converted_start_time, $converted_end_time)) {
                                                                                            $item['video_image_url'] = URL::to('public/uploads/images/'.$item->image ) ;
                                                                                            $item['converted_start_time'] = $converted_start_time->format('h:i A');
                                                                                            $item['converted_end_time']   =   $converted_end_time->format('h:i A');
                                                                                            return $item ;
                                                                                        }

                                                                                    })->filter()->first();


                        return $item;
            });

            $data =[
                'ChannelVideoScheduler' => $ChannelVideoScheduler ,
                'current_timezone'       => $current_timezone,
                'carbon_now' => $carbon_now ,
                'order_settings' => $order_settings ,
                'order_settings_list' => $order_settings_list ,
                'order_settings' => $order_settings ,
                'EPG_date_filter_status' => 1,
                ];
    
            return Theme::view('channel-video-scheduler-List', $data);

        // }                       
        // catch (\Throwable $th) {
        //     return abort(404);
        // }
    }
}
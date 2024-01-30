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
use View;
use Theme;
use Carbon\Carbon;

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
                    ->where('choosed_date', '=', Carbon::today()->format('n-d-Y'))
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

                            // case $item['url'] != null && $item['url'] == 'Gap':
                            //     $item['video_url'] = 'https://cph-p2p-msl.akamaized.net/hls/live/2000341/test/master.m3u8';
                            //     $item['mimeType'] = 'application/x-mpegURL';
                            // break;

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
}
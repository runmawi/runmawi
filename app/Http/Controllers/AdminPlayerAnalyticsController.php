<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\User as User;
use \Redirect as Redirect;
use URL;
use App\Video as Video;
use App\VideoCategory as VideoCategory;
use App\PpvCategory as PpvCategory;
use App\PlayerAnalytic as PlayerAnalytic;
use Auth;
use Hash;
use Illuminate\Support\Facades\Cache;
use Image;


class AdminPlayerAnalyticsController extends Controller
{
    public function PlayerAnalyticsCreate(Request $request){
        $user_id = Auth::user()->id;
        $videoid = $request->video_id;
        $duration = $request->duration;
        $currentTime  = $request->currentTime;
        $watch_percentage = ($currentTime * 100 / $duration);
        $seekTime = $request->seekableEnd;
        $bufferedTime = $request->bufferedTimeRangesLength;

        $player = new PlayerAnalytic;
        $player->playerid = $request->player_id;
        $player->user_id = $user_id;
        $player->duration = $request->duration;
        $player->currentTime = $currentTime;
        $player->watch_percentage = $watch_percentage;
        $player->seekTime = $request->seekableEnd;
        $player->bufferedTime = $request->bufferedTimeRangesLength;
        $player->save();
    }

}
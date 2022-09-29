<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;


class AdminRestreamController extends Controller
{
    public function Restream_index(Request $request)
    {
        return View('admin.Restream.index');
    }

    public function Restream_create(){

        $data = array(
            'current_time' => Carbon::now()->toIso8601String() ,
        );

        return View('admin.Restream.create',$data);
    }

    public function Restream_obs_store(Request $request)
    {
        $data = array(
            'restream_title' => $request->restream_title ,
            'privacy_status' => $request->privacy_status,
            'resolution'     => $request->resolution,
            'frame_rate'     => $request->frame_rate,
            'ScheduledStartTime' => $request->ScheduledStartTime,
        );

        return redirect('Create_youtube_broadcast.php')->with('data', $data);

    }

   
    
}

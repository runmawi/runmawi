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
use DB;
use App\CountryCode as CountryCode;
use App\City as City;
use App\State as State;
use App\UserLogs as UserLogs;

class AdminPlayerAnalyticsController extends Controller
{
    public function PlayerAnalyticsCreate(Request $request){


        $getfeching = \App\Geofencing::first();
        $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
        $userIp = $geoip->getip();    
        $countryName = $geoip->getCountry();
        $cityName = $geoip->getcity();
        $stateName = $geoip->getregion();

        $user_id = Auth::user()->id;
        $videoid = $request->video_id;
        $duration = $request->duration;
        $currentTime  = $request->currentTime;
        $watch_percentage = ($currentTime * 100 / $duration);
        $seekTime = $request->seekableEnd;
        $bufferedTime = $request->bufferedTimeRangesLength;
        
        if($currentTime != 0){
            $player = new PlayerAnalytic;
            $player->videoid = $request->video_id;
            $player->user_id = $user_id;
            $player->duration = $request->duration;
            $player->currentTime = $currentTime;
            $player->watch_percentage = $watch_percentage;
            $player->seekTime = $request->seekableEnd;
            $player->bufferedTime = $request->bufferedTimeRangesLength;
            $player->country_name = $countryName;
            $player->state_name = $stateName;
            $player->city_name = $cityName;
            $player->save();
        }
        return 1 ;
    }
    
    public function PlayerAnalyticsStore(Request $request){

        $getfeching = \App\Geofencing::first();
        $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();
        $userIp = $geoip->getip();    
        $countryName = $geoip->getCountry();
        $cityName = $geoip->getcity();
        $stateName = $geoip->getregion();
        
        $user_id = Auth::user()->id;
        $videoid = $request->video_id;
        $duration = $request->duration;
        $currentTime  = $request->currentTime;
        $watch_percentage = ($currentTime * 100 / $duration);
        $seekTime = $request->seekableEnd;
        $bufferedTime = $request->bufferedTimeRangesLength;
        if($currentTime != 0){
            $player = new PlayerAnalytic;
            $player->videoid = $request->video_id;
            $player->user_id = $user_id;
            $player->duration = $request->duration;
            $player->currentTime = $currentTime;
            $player->watch_percentage = $watch_percentage;
            $player->seekTime = $request->seekableEnd;
            $player->bufferedTime = $request->bufferedTimeRangesLength;
            $player->country_name = $countryName;
            $player->state_name = $stateName;
            $player->city_name = $cityName;
            $player->save();
        }
        return 1 ;

    }


    public function PlayerVideoAnalytics(Request $request){

        $player_videos_count = PlayerAnalytic::get([ \DB::raw("COUNT(videoid) as count")]); 
        // groupBy('videoid')->


        $player_videos = PlayerAnalytic::join('users', 'users.id', '=', 'player_analytics.user_id')
        ->leftjoin('videos', 'videos.id', '=', 'player_analytics.videoid')
        // $player_videos = PlayerAnalytic::groupBy('videoid')
        ->groupBy('player_analytics.videoid')
        ->orderBy('player_analytics.created_at')
        ->get(['player_analytics.videoid','player_analytics.user_id','users.username','videos.title',
        DB::raw('sum(player_analytics.duration) as duration') ,
         DB::raw('sum(player_analytics.currentTime) as currentTime') ,
         DB::raw('(player_analytics.seekTime) as seekTime') ,
         DB::raw('(player_analytics.bufferedTime) as bufferedTime') ,
         DB::raw('sum(player_analytics.watch_percentage) as watch_percentage') ,
         \DB::raw("MONTHNAME(player_analytics.created_at) as month_name") ,
         \DB::raw("COUNT(player_analytics.videoid) as count"),
         \DB::raw("(player_analytics.watch_percentage) as watchpercentage"),
        //  floor($player_videos[1]->duration / 60)
        ]);

    //    dd($player_videos);
        $player_videos_count =  count($player_videos);
        // dd($player_videos_count);

        // $milliseconds = $player_videos[1]->duration;
        // $seconds = $player_videos[1]->duration;
        // $minutes = floor($player_videos[1]->duration / 60);
        // $minutes = ;
        // $milliseconds = $milliseconds % 1000;
        // $seconds = $seconds % 60;
        // $minutes = $minutes % 60;
        // dd(gmdate($player_videos[1]->durations));
    
        // $format = '%u:%02u:%02u.%03u';
        // $time = sprintf($format, $hours, $minutes, $seconds, $milliseconds);
        // $playervideos = rtrim($time, '0');
        // $playervideos = gmdate("H:i:s", $player_videos[2]->watch_percentage);
        $data = array(
            'player_videos' => $player_videos,
            'player_videos_count' => $player_videos_count,
        );
        return \View::make('admin.analytics.player_video_analytics', $data);

    }

    public function PlayerVideosStartDateRecord(Request $request)
    {
        // 2022-04-01
        $data = $request->all();

        $start_time = $data['start_time'];
        $end_time = $data['end_time'];
        if (!empty($start_time) && empty($end_time))
        {
            $player_videos = PlayerAnalytic::join('users', 'users.id', '=', 'player_analytics.user_id')
            ->leftjoin('videos', 'videos.id', '=', 'player_analytics.videoid')
            // ->groupBy('player_analytics.videoid')
            ->orderBy('player_analytics.created_at')
            ->whereDate('player_analytics.created_at', '>=', $start_time)->groupBy('month_name')
            ->get(['player_analytics.videoid','player_analytics.user_id','users.username','videos.title',
            DB::raw('sum(player_analytics.duration) as duration') ,
             DB::raw('sum(player_analytics.currentTime) as currentTime') ,
             DB::raw('(player_analytics.seekTime) as seekTime') ,
             DB::raw('(player_analytics.bufferedTime) as bufferedTime') ,
             DB::raw('sum(player_analytics.watch_percentage) as watch_percentage') ,
             \DB::raw("MONTHNAME(player_analytics.created_at) as month_name") ,
             \DB::raw("COUNT(player_analytics.videoid) as count"),
             \DB::raw("(player_analytics.watch_percentage) as watchpercentage"),
            ]);
    
        //    dd($player_videos);
            $player_videos_count =  count($player_videos);

       }

        $output = '';
        $i = 1;

        $total_row = $player_videos->count();
        if (!empty($player_videos))
        {
            foreach ($player_videos as $key => $row)
            {
                if(!empty($playervideo->bufferedTime))  { $bufferedTime = $row->bufferedTime; } else { $bufferedTime = 'No Buffer'; }

                 $output .= '
               <tr>
               <td>' . $i++ . '</td>
               <td>' . $row->title . '</td>
               <td>' . $row->count . '</td>    
               <td>' . $row->watchpercentage . '</td>  
               <td>' . $row->seekTime . '</td>    
               <td>' . $bufferedTime . '</td>    
              </tr>
              ';

            }
        }
        else
        {
            $output = '
          <tr>
           <td align="center" colspan="5">No Data Found</td>
          </tr>
          ';
        }
        $value = array(
            'table_data' => $output,
            'total_data' => $total_row,
            'total_Revenue' => $player_videos,

        );

        return $value;

    }

    public function PlayerVideosEndDateRecord(Request $request)
    {

        $data = $request->all();

        $start_time = $data['start_time'];
        $end_time = $data['end_time'];

        if (!empty($start_time) && !empty($end_time))
        {
            $player_videos = PlayerAnalytic::join('users', 'users.id', '=', 'player_analytics.user_id')
            ->leftjoin('videos', 'videos.id', '=', 'player_analytics.videoid')
            // ->groupBy('player_analytics.videoid')
            ->orderBy('player_analytics.created_at')
            ->whereBetween('player_analytics.created_at', [$start_time, $end_time])->groupBy('month_name')
            ->get(['player_analytics.videoid','player_analytics.user_id','users.username','videos.title',
            DB::raw('sum(player_analytics.duration) as duration') ,
             DB::raw('sum(player_analytics.currentTime) as currentTime') ,
             DB::raw('(player_analytics.seekTime) as seekTime') ,
             DB::raw('(player_analytics.bufferedTime) as bufferedTime') ,
             DB::raw('sum(player_analytics.watch_percentage) as watch_percentage') ,
             \DB::raw("MONTHNAME(player_analytics.created_at) as month_name") ,
             \DB::raw("COUNT(player_analytics.videoid) as count"),
             \DB::raw("(player_analytics.watch_percentage) as watchpercentage"),
            ]);
    
        //    dd($player_videos);
            $player_videos_count =  count($player_videos);
        }

        $output = '';
        $i = 1;

        $total_row = $player_videos->count();
        if (!empty($player_videos))
        {
            foreach ($player_videos as $key => $row)
            {
                if(!empty($playervideo->bufferedTime))  { $bufferedTime = $row->bufferedTime; } else { $bufferedTime = 'No Buffer'; }
                
                $output .= '
              <tr>
              <td>' . $i++ . '</td>
              <td>' . $row->title . '</td>
              <td>' . $row->count . '</td>    
              <td>' . $row->watchpercentage . '</td>  
              <td>' . $row->seekTime . '</td>    
              <td>' . $bufferedTime . '</td>     
              </tr>
              ';

            }
        }
        else
        {
            $output = '
          <tr>
           <td align="center" colspan="5">No Data Found</td>
          </tr>
          ';
        }
        $value = array(
            'table_data' => $output,
            'total_data' => $total_row,
            'total_Revenue' => $player_videos,
        );

        return $value;
    }



    public function RegionVideoAnalytics(Request $request){

        $player_videos_count = PlayerAnalytic::get([ \DB::raw("COUNT(videoid) as count")]); 
        $CountryCode = CountryCode::get();
        $State = State::get();
        $City = City::get();

        $player_videos = PlayerAnalytic::join('users', 'users.id', '=', 'player_analytics.user_id')
        ->leftjoin('videos', 'videos.id', '=', 'player_analytics.videoid')
        ->groupBy('player_analytics.country_name')
        ->orderBy('player_analytics.created_at')
        ->get(['player_analytics.videoid','player_analytics.user_id','users.username','videos.title',
        'player_analytics.country_name','player_analytics.state_name','player_analytics.city_name',
        DB::raw('sum(player_analytics.duration) as duration') ,
         DB::raw('sum(player_analytics.currentTime) as currentTime') ,
         DB::raw('(player_analytics.seekTime) as seekTime') ,
         DB::raw('(player_analytics.bufferedTime) as bufferedTime') ,
         DB::raw('sum(player_analytics.watch_percentage) as watch_percentage') ,
         \DB::raw("MONTHNAME(player_analytics.created_at) as month_name") ,
         \DB::raw("COUNT(player_analytics.videoid) as count"),
         \DB::raw("(player_analytics.watch_percentage) as watchpercentage"),
        ]);
        //    dd($player_videos);

        $player_videos_count =  count($player_videos);

        $data = array(
            'player_videos' => $player_videos,
            'player_videos_count' => $player_videos_count,
            'Country' => $CountryCode,
            'City' => $City,
            'State' => $State,
        );
        return \View::make('admin.analytics.video_by_region', $data);

    }


    public function RegionVideoAllCountry(Request $request)
    {
        if ($request->ajax())
        {

            $output = '';
            $query = $request->get('query');

            if ($query != '')
            {

                $player_videos = PlayerAnalytic::join('users', 'users.id', '=', 'player_analytics.user_id')
                ->leftjoin('videos', 'videos.id', '=', 'player_analytics.videoid')
                ->groupBy('player_analytics.country_name')
                ->orderBy('player_analytics.created_at')
                ->get(['player_analytics.videoid','player_analytics.user_id','users.username','videos.title',
                'player_analytics.country_name','player_analytics.state_name','player_analytics.city_name',
                DB::raw('sum(player_analytics.duration) as duration') ,
                 DB::raw('sum(player_analytics.currentTime) as currentTime') ,
                 DB::raw('(player_analytics.seekTime) as seekTime') ,
                 DB::raw('(player_analytics.bufferedTime) as bufferedTime') ,
                 DB::raw('sum(player_analytics.watch_percentage) as watch_percentage') ,
                 \DB::raw("MONTHNAME(player_analytics.created_at) as month_name") ,
                 \DB::raw("COUNT(player_analytics.videoid) as count"),
                 \DB::raw("(player_analytics.watch_percentage) as watchpercentage"),
                ]);

            }
            else
            {

            }
            $total_row = $player_videos->count();
            if (!empty($player_videos))
            {
                foreach ($player_videos as $key => $row)
                {
                    if(!empty($playervideo->bufferedTime))  { $bufferedTime = $row->bufferedTime; } else { $bufferedTime = 'No Buffer'; }
                    
                    $output .= '
                  <tr>
                  <td>' . $i++ . '</td>
                  <td>' . $row->title . '</td>
                  <td>' . $row->count . '</td>    
                  <td>' . $row->watchpercentage . '</td>  
                  <td>' . $row->seekTime . '</td>    
                  <td>' . $row->bufferedTime . '</td>  
                  <td>' . $row->country_name . '</td>     
                  <td>' . $row->state_name . '</td>
                  <td>' . $row->city_name . '</td>     


                  </tr>
                  ';
    
                }
            }
            else
            {
                $output = '
              <tr>
               <td align="center" colspan="5">No Data Found</td>
              </tr>
              ';
            }
            $value = array(
                'table_data' => $output,
                'total_data' => $total_row,
                'total_Revenue' => $player_videos,
            );
    
            return $value;          
        }
    }

    public function RegionVideoState(Request $request)
    {
        if ($request->ajax())
        {

            $output = '';
            $query = $request->get('query');
            // print_r($query);exit;
            if ($query != '' && $request->get('query') != 'Allstate')
            {
                $CountryCode = CountryCode::get();
                $State = State::get();
                $City = City::get();
                $Statename = State::where('id',$query)->first(); 
                if(!empty($Statename) ){
                    $player_videos = PlayerAnalytic::join('users', 'users.id', '=', 'player_analytics.user_id')
                    ->leftjoin('videos', 'videos.id', '=', 'player_analytics.videoid')
                    ->groupBy('player_analytics.state_name')
                    ->orderBy('player_analytics.created_at')
                    ->where('player_analytics.state_name','=',$Statename->name)
                    ->get(['player_analytics.videoid','player_analytics.user_id','users.username','videos.title',
                    'player_analytics.country_name','player_analytics.state_name','player_analytics.city_name',
                    DB::raw('sum(player_analytics.duration) as duration') ,
                     DB::raw('sum(player_analytics.currentTime) as currentTime') ,
                     DB::raw('(player_analytics.seekTime) as seekTime') ,
                     DB::raw('(player_analytics.bufferedTime) as bufferedTime') ,
                     DB::raw('sum(player_analytics.watch_percentage) as watch_percentage') ,
                     \DB::raw("MONTHNAME(player_analytics.created_at) as month_name") ,
                     \DB::raw("COUNT(player_analytics.videoid) as count"),
                     \DB::raw("(player_analytics.watch_percentage) as watchpercentage"),
                    ]);
                }
            }elseif($request->get('query') == 'Allstate'){

                $player_videos = PlayerAnalytic::join('users', 'users.id', '=', 'player_analytics.user_id')
                ->leftjoin('videos', 'videos.id', '=', 'player_analytics.videoid')
                ->groupBy('player_analytics.state_name')
                ->orderBy('player_analytics.created_at')
                ->get(['player_analytics.videoid','player_analytics.user_id','users.username','videos.title',
                'player_analytics.country_name','player_analytics.state_name','player_analytics.city_name',
                DB::raw('sum(player_analytics.duration) as duration') ,
                 DB::raw('sum(player_analytics.currentTime) as currentTime') ,
                 DB::raw('(player_analytics.seekTime) as seekTime') ,
                 DB::raw('(player_analytics.bufferedTime) as bufferedTime') ,
                 DB::raw('sum(player_analytics.watch_percentage) as watch_percentage') ,
                 \DB::raw("MONTHNAME(player_analytics.created_at) as month_name") ,
                 \DB::raw("COUNT(player_analytics.videoid) as count"),
                 \DB::raw("(player_analytics.watch_percentage) as watchpercentage"),
                ]);
            }
            else
            {

            }
            $output = '';
            $i = 1;
    
            $total_row = $player_videos->count();
            if (!empty($player_videos))
            {
                foreach ($player_videos as $key => $row)
                {
                    if(!empty($playervideo->bufferedTime))  { $bufferedTime = $row->bufferedTime; } else { $bufferedTime = 'No Buffer'; }
                    
                    $output .= '
                  <tr>
                  <td>' . $i++ . '</td>
                  <td>' . $row->title . '</td>
                  <td>' . $row->count . '</td>    
                  <td>' . $row->watchpercentage . '</td>  
                  <td>' . $row->seekTime . '</td>    
                  <td>' . $row->bufferedTime . '</td>  
                  <td>' . $row->country_name . '</td>     
                  <td>' . $row->state_name . '</td>
                  <td>' . $row->city_name . '</td>     


                  </tr>
                  ';
    
                }
            }
            else
            {
                $output = '
              <tr>
               <td align="center" colspan="5">No Data Found</td>
              </tr>
              ';
            }
            $value = array(
                'table_data' => $output,
                'total_data' => $total_row,
                'total_Revenue' => $player_videos,
            );
    
            return $value;          
        }
    }

    public function RegionVideoCity(Request $request)
    {
        if ($request->ajax())
        {

            $output = '';
            $query = $request->get('query');

            if ($query != '' && $request->get('query') == 'Allcity')
            {
                $CountryCode = CountryCode::get();
                $State = State::get();
                $City = City::get();
                $cityname = City::where('id',$query)->first(); 
                if(!empty($cityname)){
                    $player_videos = PlayerAnalytic::join('users', 'users.id', '=', 'player_analytics.user_id')
                    ->leftjoin('videos', 'videos.id', '=', 'player_analytics.videoid')
                    ->groupBy('player_analytics.city_name')
                    ->orderBy('player_analytics.created_at')
                    ->where('player_analytics.city_name','=',$cityname->name)
                    ->get(['player_analytics.videoid','player_analytics.user_id','users.username','videos.title',
                    'player_analytics.country_name','player_analytics.state_name','player_analytics.city_name',
                    DB::raw('sum(player_analytics.duration) as duration') ,
                     DB::raw('sum(player_analytics.currentTime) as currentTime') ,
                     DB::raw('(player_analytics.seekTime) as seekTime') ,
                     DB::raw('(player_analytics.bufferedTime) as bufferedTime') ,
                     DB::raw('sum(player_analytics.watch_percentage) as watch_percentage') ,
                     \DB::raw("MONTHNAME(player_analytics.created_at) as month_name") ,
                     \DB::raw("COUNT(player_analytics.videoid) as count"),
                     \DB::raw("(player_analytics.watch_percentage) as watchpercentage"),
                    ]);
                }elseif($request->get('query') == 'Allcity'){

                    $player_videos = PlayerAnalytic::join('users', 'users.id', '=', 'player_analytics.user_id')
                    ->leftjoin('videos', 'videos.id', '=', 'player_analytics.videoid')
                    ->groupBy('player_analytics.city_name')
                    ->orderBy('player_analytics.created_at')
                    ->get(['player_analytics.videoid','player_analytics.user_id','users.username','videos.title',
                    'player_analytics.country_name','player_analytics.state_name','player_analytics.city_name',
                    DB::raw('sum(player_analytics.duration) as duration') ,
                     DB::raw('sum(player_analytics.currentTime) as currentTime') ,
                     DB::raw('(player_analytics.seekTime) as seekTime') ,
                     DB::raw('(player_analytics.bufferedTime) as bufferedTime') ,
                     DB::raw('sum(player_analytics.watch_percentage) as watch_percentage') ,
                     \DB::raw("MONTHNAME(player_analytics.created_at) as month_name") ,
                     \DB::raw("COUNT(player_analytics.videoid) as count"),
                     \DB::raw("(player_analytics.watch_percentage) as watchpercentage"),
                    ]);
                }
            }
            else
            {

            }
            $output = '';
            $i = 1;
    
            $total_row = $player_videos->count();
            if (!empty($player_videos))
            {
                foreach ($player_videos as $key => $row)
                {
                    if(!empty($playervideo->bufferedTime))  { $bufferedTime = $row->bufferedTime; } else { $bufferedTime = 'No Buffer'; }
                    
                    $output .= '
                  <tr>
                  <td>' . $i++ . '</td>
                  <td>' . $row->title . '</td>
                  <td>' . $row->count . '</td>    
                  <td>' . $row->watchpercentage . '</td>  
                  <td>' . $row->seekTime . '</td>    
                  <td>' . $row->bufferedTime . '</td>  
                  <td>' . $row->country_name . '</td>     
                  <td>' . $row->state_name . '</td>
                  <td>' . $row->city_name . '</td>     


                  </tr>
                  ';
    
                }
            }
            else
            {
                $output = '
              <tr>
               <td align="center" colspan="5">No Data Found</td>
              </tr>
              ';
            }
            $value = array(
                'table_data' => $output,
                'total_data' => $total_row,
                'total_Revenue' => $player_videos,
            );
    
            return $value;          
        }
    }

    public function RegionVideoAllCity(Request $request)
    {
        if ($request->ajax())
        {

            $output = '';
            $query = $request->get('query');

            if ($query != '' && $request->get('query') != 'Allcity')
            {

                $player_videos = PlayerAnalytic::join('users', 'users.id', '=', 'player_analytics.user_id')
                ->leftjoin('videos', 'videos.id', '=', 'player_analytics.videoid')
                ->groupBy('player_analytics.city_name')
                ->orderBy('player_analytics.created_at')
                ->get(['player_analytics.videoid','player_analytics.user_id','users.username','videos.title',
                'player_analytics.country_name','player_analytics.state_name','player_analytics.city_name',
                DB::raw('sum(player_analytics.duration) as duration') ,
                 DB::raw('sum(player_analytics.currentTime) as currentTime') ,
                 DB::raw('(player_analytics.seekTime) as seekTime') ,
                 DB::raw('(player_analytics.bufferedTime) as bufferedTime') ,
                 DB::raw('sum(player_analytics.watch_percentage) as watch_percentage') ,
                 \DB::raw("MONTHNAME(player_analytics.created_at) as month_name") ,
                 \DB::raw("COUNT(player_analytics.videoid) as count"),
                 \DB::raw("(player_analytics.watch_percentage) as watchpercentage"),
                ]);

            }elseif($request->get('query') == 'Allcity'){

                $player_videos = PlayerAnalytic::join('users', 'users.id', '=', 'player_analytics.user_id')
                ->leftjoin('videos', 'videos.id', '=', 'player_analytics.videoid')
                ->groupBy('player_analytics.city_name')
                ->orderBy('player_analytics.created_at')
                ->get(['player_analytics.videoid','player_analytics.user_id','users.username','videos.title',
                'player_analytics.country_name','player_analytics.state_name','player_analytics.city_name',
                DB::raw('sum(player_analytics.duration) as duration') ,
                 DB::raw('sum(player_analytics.currentTime) as currentTime') ,
                 DB::raw('(player_analytics.seekTime) as seekTime') ,
                 DB::raw('(player_analytics.bufferedTime) as bufferedTime') ,
                 DB::raw('sum(player_analytics.watch_percentage) as watch_percentage') ,
                 \DB::raw("MONTHNAME(player_analytics.created_at) as month_name") ,
                 \DB::raw("COUNT(player_analytics.videoid) as count"),
                 \DB::raw("(player_analytics.watch_percentage) as watchpercentage"),
                ]);
            }
            else
            {

            }
            $total_row = $player_videos->count();
            if (!empty($player_videos))
            {
                foreach ($player_videos as $key => $row)
                {
                    if(!empty($playervideo->bufferedTime))  { $bufferedTime = $row->bufferedTime; } else { $bufferedTime = 'No Buffer'; }
                    
                    $output .= '
                  <tr>
                  <td>' . $i++ . '</td>
                  <td>' . $row->title . '</td>
                  <td>' . $row->count . '</td>    
                  <td>' . $row->watchpercentage . '</td>  
                  <td>' . $row->seekTime . '</td>    
                  <td>' . $row->bufferedTime . '</td>  
                  <td>' . $row->country_name . '</td>     
                  <td>' . $row->state_name . '</td>
                  <td>' . $row->city_name . '</td>     


                  </tr>
                  ';
    
                }
            }
            else
            {
                $output = '
              <tr>
               <td align="center" colspan="5">No Data Found</td>
              </tr>
              ';
            }
            $value = array(
                'table_data' => $output,
                'total_data' => $total_row,
                'total_Revenue' => $player_videos,
            );
    
            return $value;          
        }
    }

    public function RegionGetState (Request $request)
    {
        $data['states'] = State::where("country_id", $request->country_id)
            ->get(["name", "id"]);
        return response()
            ->json($data);
    }
    public function RegionGetCity(Request $request)
    {
        $data['cities'] = City::where("state_id", $request->state_id)
            ->get(["name", "id"]);
        return response()
            ->json($data);
    }


    public function PlayerUserAnalytics()
    {
        $player_videos_count = PlayerAnalytic::get([ \DB::raw("COUNT(videoid) as count")]); 

        $player_videos = PlayerAnalytic::join('users', 'users.id', '=', 'player_analytics.user_id')
        ->leftjoin('videos', 'videos.id', '=', 'player_analytics.videoid')
        ->groupBy('player_analytics.user_id')
        ->orderBy('player_analytics.created_at')
        ->get(['player_analytics.videoid','player_analytics.user_id','users.username','videos.title',
        DB::raw('sum(player_analytics.duration) as duration') ,
         DB::raw('sum(player_analytics.currentTime) as currentTime') ,
         DB::raw('(player_analytics.seekTime) as seekTime') ,
         DB::raw('(player_analytics.bufferedTime) as bufferedTime') ,
         DB::raw('sum(player_analytics.watch_percentage) as watch_percentage') ,
         \DB::raw("MONTHNAME(player_analytics.created_at) as month_name") ,
         \DB::raw("COUNT(player_analytics.videoid) as count"),
         \DB::raw("(player_analytics.watch_percentage) as watchpercentage"),
        ]);

        $player_videos_count =  count($player_videos);
        $UserLogs_count = UserLogs::get()->count(); 
       
        $data = array(
            'player_videos' => $player_videos,
            'player_videos_count' => $player_videos_count,
            'UserLogs_count' => $UserLogs_count,
        );
        return \View::make('admin.analytics.player_user_analytics', $data);


    }



    public function PlayerUsersStartDateRecord(Request $request)
    {
        // 2022-04-01
        $data = $request->all();

        $start_time = $data['start_time'];
        $end_time = $data['end_time'];
        if (!empty($start_time) && empty($end_time))
        {
            $player_videos = PlayerAnalytic::join('users', 'users.id', '=', 'player_analytics.user_id')
            ->leftjoin('videos', 'videos.id', '=', 'player_analytics.videoid')
            // ->groupBy('player_analytics.videoid')
            ->orderBy('player_analytics.created_at')
            ->whereDate('player_analytics.created_at', '>=', $start_time)->groupBy('month_name')
            ->get(['player_analytics.videoid','player_analytics.user_id','users.username','videos.title',
            DB::raw('sum(player_analytics.duration) as duration') ,
             DB::raw('sum(player_analytics.currentTime) as currentTime') ,
             DB::raw('(player_analytics.seekTime) as seekTime') ,
             DB::raw('(player_analytics.bufferedTime) as bufferedTime') ,
             DB::raw('sum(player_analytics.watch_percentage) as watch_percentage') ,
             \DB::raw("MONTHNAME(player_analytics.created_at) as month_name") ,
             \DB::raw("COUNT(player_analytics.videoid) as count"),
             \DB::raw("(player_analytics.watch_percentage) as watchpercentage"),
            ]);
    
        //    dd($player_videos);
            $player_videos_count =  count($player_videos);

       }

        $output = '';
        $i = 1;

        $total_row = $player_videos->count();
        if (!empty($player_videos))
        {
            foreach ($player_videos as $key => $row)
            {
                if(!empty($playervideo->bufferedTime))  { $bufferedTime = $row->bufferedTime; } else { $bufferedTime = 'No Buffer'; }

                 $output .= '
               <tr>
               <td>' . $i++ . '</td>
               <td>' . $row->username . '</td>
               <td>' . $row->count . '</td>    
               <td>' . $row->watchpercentage . '</td>  
               <td>' . $row->seekTime . '</td>    
               <td>' . $bufferedTime . '</td>    
              </tr>
              ';

            }
        }
        else
        {
            $output = '
          <tr>
           <td align="center" colspan="5">No Data Found</td>
          </tr>
          ';
        }
        $value = array(
            'table_data' => $output,
            'total_data' => $total_row,
            'total_Revenue' => $player_videos,

        );

        return $value;

    }

    public function PlayerUsersEndDateRecord(Request $request)
    {

        $data = $request->all();

        $start_time = $data['start_time'];
        $end_time = $data['end_time'];

        if (!empty($start_time) && !empty($end_time))
        {
            $player_videos = PlayerAnalytic::join('users', 'users.id', '=', 'player_analytics.user_id')
            ->leftjoin('videos', 'videos.id', '=', 'player_analytics.videoid')
            // ->groupBy('player_analytics.videoid')
            ->orderBy('player_analytics.created_at')
            ->whereBetween('player_analytics.created_at', [$start_time, $end_time])->groupBy('month_name')
            ->get(['player_analytics.videoid','player_analytics.user_id','users.username','videos.title',
            DB::raw('sum(player_analytics.duration) as duration') ,
             DB::raw('sum(player_analytics.currentTime) as currentTime') ,
             DB::raw('(player_analytics.seekTime) as seekTime') ,
             DB::raw('(player_analytics.bufferedTime) as bufferedTime') ,
             DB::raw('sum(player_analytics.watch_percentage) as watch_percentage') ,
             \DB::raw("MONTHNAME(player_analytics.created_at) as month_name") ,
             \DB::raw("COUNT(player_analytics.videoid) as count"),
             \DB::raw("(player_analytics.watch_percentage) as watchpercentage"),
            ]);
    
        //    dd($player_videos);
            $player_videos_count =  count($player_videos);
        }

        $output = '';
        $i = 1;

        $total_row = $player_videos->count();
        if (!empty($player_videos))
        {
            foreach ($player_videos as $key => $row)
            {
                if(!empty($playervideo->bufferedTime))  { $bufferedTime = $row->bufferedTime; } else { $bufferedTime = 'No Buffer'; }
                
                $output .= '
              <tr>
              <td>' . $i++ . '</td>
              <td>' . $row->username . '</td>
              <td>' . $row->count . '</td>    
              <td>' . $row->watchpercentage . '</td>  
              <td>' . $row->seekTime . '</td>    
              <td>' . $bufferedTime . '</td>     
              </tr>
              ';

            }
        }
        else
        {
            $output = '
          <tr>
           <td align="center" colspan="5">No Data Found</td>
          </tr>
          ';
        }
        $value = array(
            'table_data' => $output,
            'total_data' => $total_row,
            'total_Revenue' => $player_videos,
        );

        return $value;
    }

    
}
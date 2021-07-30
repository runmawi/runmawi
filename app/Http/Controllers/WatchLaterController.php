<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Watchlater;
use App\Video as Video;
use App\PpvVideo as PpvVideo;
use App\PpvPurchase as PpvPurchase;
use Auth;
use View;
class WatchLaterController extends Controller
{
  public function watchlater(Request $request){
      
		$video_id = $request['video_id'];
        
        if($video_id){
            $watchlater = Watchlater::where('user_id', '=', Auth::user()->id)->where('video_id', '=', $video_id)->where('type', '=', 'channel')->first();
            if(isset($watchlater->id)){ 
                $watchlater->delete();
                 return response()->json(['success' => 'Removed From Watchlater List']);
            } else {
                $watchlater = new Watchlater;
                $watchlater->user_id = Auth::user()->id;
                $watchlater->video_id = $video_id;
                $watchlater->type = 'channel';
                $watchlater->save();
                 return response()->json(['success' => 'Added to Watchlater List']);
                //echo $watchlater;
            }
        } 
    } 
    
    
    public function ppvWatchlater(Request $request){
      
		$video_id = $request['video_id'];
        
        if($video_id){
            
            $watchlater = Watchlater::where('user_id', '=', Auth::user()->id)->where('video_id', '=', $video_id)->where('type', '=', 'ppv')->first();
            if(isset($watchlater->id)){ 
                $watchlater->delete();
            } else {
                $watchlater = new Watchlater;
                $watchlater->user_id = Auth::user()->id;
                $watchlater->video_id = $video_id;
                $watchlater->type = 'ppv';
                $watchlater->save();
                echo $watchlater;
            }
        } 
    } 
    
     public function show_watchlaters(){
            $channelwatchlater = Watchlater::where('user_id', '=', Auth::user()->id)->where('type', '=', 'channel')->get();
            $ppvwatchlater = Watchlater::where('user_id', '=', Auth::user()->id)->where('type', '=', 'ppv')->get();
      
      
            $channel_watchlater_array = array();
			foreach($channelwatchlater as $key => $cfave){
				array_push($channel_watchlater_array, $cfave->video_id);
			} 
      
            $ppv_watchlater_array = array();
			foreach($ppvwatchlater as $key => $ccfave){
				array_push($ppv_watchlater_array, $ccfave->video_id);
			}
             
            $videos = Video::where('active', '=', '1')->whereIn('id', $channel_watchlater_array)->paginate(12);
            $ppvvideos = PpvVideo::where('active', '=', '1')->whereIn('id', $ppv_watchlater_array)->paginate(12);
      
             $data = array(
                     'ppvwatchlater' => $ppvvideos,
                     'channelwatchlater' => $videos
              );

             return view('mywatchlater', $data);
        
        }      
    
        public function showPayperview(){
          $showppv = PpvPurchase::where('user_id', '=', Auth::user()->id)->get();
          $ppv_array = array();
          foreach($showppv as $key => $ccfave){
            array_push($ppv_array, $ccfave->video_id);
          }
          $ppvvideos = Video::where('active', '=', '1')->whereIn('id', $ppv_array)->paginate(12);
          $data = array(
            'ppv' => $ppvvideos,
          );
          return view('myppv', $data);
        } 
    
}

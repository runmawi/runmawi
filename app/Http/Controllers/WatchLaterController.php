<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Watchlater;
use App\Video as Video;
use App\PpvVideo as PpvVideo;
use App\PpvPurchase as PpvPurchase;
use App\LivePurchase as LivePurchase;
use App\CurrencySetting as CurrencySetting;
use App\HomeSetting;
use Auth;
use View;
use Theme;
use App\Episode;
use App\ThumbnailSetting;

class WatchLaterController extends Controller
{
  public function watchlater(Request $request){
      
		$video_id = $request['video_id'];
        
        if($video_id){
            $watchlater = Watchlater::where('user_id', '=', Auth::user()->id)->where('video_id', '=', $video_id)->where('type', '=', 'channel')->first();
            if(isset($watchlater->id)){ 
                $watchlater->delete();
                //  return response()->json(['success' => 'Removed From Watchlater List']);
                $response = "Removed From Wishlist";
                return $response;
            } else {
                $watchlater = new Watchlater;
                $watchlater->user_id = Auth::user()->id;
                $watchlater->video_id = $video_id;
                $watchlater->type = 'channel';
                $watchlater->save();
                //  return response()->json(['success' => 'Added to Watchlater List']);
                $response = "Added To Wishlist";
                return $response;
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

      $Theme = HomeSetting::pluck('theme_choosen')->first();
      Theme::uses($Theme);

        if(Auth::guest()){
            return redirect('/login');
        }
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
            
            $episode_videos = Episode::join('watchlaters','watchlaters.episode_id','=','episodes.id')
                                      ->where('active','=','1')->latest('episodes.created_at')
                                      ->get();
             
            $data = array(
                     'ppvwatchlater' => $ppvvideos,
                     'channelwatchlater' => $videos,
                     'episode_videos' => $episode_videos,
                     'ThumbnailSetting' => ThumbnailSetting::first(),
              );

             return Theme::view('mywatchlater', $data);
        
        }      
    
        public function showPayperview(){
          $Theme = HomeSetting::pluck('theme_choosen')->first();
          Theme::uses($Theme);
          
            if(Auth::guest()){
                return redirect('/login');
            }
          $showppv = PpvPurchase::where('user_id', '=', Auth::user()->id)->get();
          $ppvlive = LivePurchase::where('user_id', '=', Auth::user()->id)->get();
       

          $ppv_array = array();
          $ppvlive_array = array();
          foreach($showppv as $key => $ccfave){
            array_push($ppv_array, $ccfave->video_id);
          }
          foreach($ppvlive as $key => $ccfave){
            array_push($ppvlive_array, $ccfave->video_id);
          }
      
          $ppvvideos = Video::where('active', '=', '1')->whereIn('id', $ppv_array)->paginate(12);
          $ppvlivevideos = Video::where('active', '=', '1')->whereIn('id', $ppvlive_array)->paginate(12);
          $data = array(
            'ppv' => $ppvvideos,
            'ppvlive' => $ppvlivevideos,
            'currency' => CurrencySetting::first(),
            
          );
          return Theme::view('myppv', $data);
        } 
    
        
      public function episode_watchlist(Request $request)
      {
 
         if(Auth::guest()){
 
           $data = array(
             "message" => "guest" ,
           );
 
           return $data ;
 
         }else{
 
           $watchlater = Watchlater::where('user_id',Auth::user()->id)->where('episode_id',$request->episode_id)->get();
         
           if(count($watchlater) == 0){
   
             Watchlater::create([
               'user_id'  => Auth::user()->id,
               'episode_id' => $request->episode_id,
               'type'     => 0,
             ]);
   
             $data = array(
               "message" => "Remove the Watch list" ,
             );
   
           }else{
             
             Watchlater::where('user_id',Auth::user()->id)->where('episode_id',$request->episode_id)->delete();
   
               $data = array(
                 "message" => "Add the Watch list" ,
               );
           }
            return $data ;
           
         }
 
      }   
 
      public function episode_watchlist_remove(Request $request)
      {
          Watchlater::where('user_id',Auth::user()->id)->where('episode_id',$request->episode_id)->delete();
      
          $data = array(
            "message" => "Add the Watch list" ,
          );
    
          return $data ;
      }


}

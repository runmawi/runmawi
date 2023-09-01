<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Wishlist;
use App\Video as Video;
use App\PpvVideo as PpvVideo;
use App\HomeSetting;
use Auth;
use View;
use Session;
use Theme;
use App\LiveStream;
use App\Episode;
use App\ThumbnailSetting;

class WishlistController extends Controller
{
    public function mywishlist(Request $request)
    {
            
        $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();

        $video_id = $request['video_id'];
        Session::flash('success', __('Password change successfully. Please Login again'));

        if ($video_id)
        {
            $wishlist = Wishlist::where('video_id', '=', $video_id)->where('type', '=', 'channel');

            if( !Auth::guest() ){
                $wishlist = $wishlist->where('user_id', Auth::user()->id) ;
            }else{
                $wishlist = $wishlist->where('users_ip_address', $geoip->getIP() );
            }

            $wishlist = $wishlist->first();

            if (isset($wishlist->id))
            {
                $wishlist->delete();
                $response = "Removed From Wishlist";
                return $response;
            }
            else
            {
                $wishlist = new Wishlist;

                if( !Auth::guest() ){
                    $wishlist->user_id = Auth::user()->id;

                }else{
                    $wishlist->users_ip_address = $geoip->getIP() ;
                }

                $wishlist->video_id = $video_id;
                $wishlist->type = 'channel';
                $wishlist->save();

                Session::flash('success', 'Product Suucess!');
                $response = "Added To Wishlist";
                return $response;
            }
        }
    }

    public function ppvWishlist(Request $request)
    {

        $video_id = $request['video_id'];

        if ($video_id)
        {
            $watchlater = Wishlist::where('user_id', '=', Auth::user()->id)
                ->where('video_id', '=', $video_id)->where('type', '=', 'ppv')
                ->first();
            if (isset($watchlater->id))
            {
                $watchlater->delete();
            }
            else
            {
                $watchlater = new Wishlist;
                $watchlater->user_id = Auth::user()->id;
                $watchlater->video_id = $video_id;
                $watchlater->type = 'ppv';
                $watchlater->save();
                echo $watchlater;
            }

        }
    }

    public function show_mywishlists()
    {
        $Theme = HomeSetting::pluck('theme_choosen')->first();
        Theme::uses($Theme);
        
        if (Auth::guest())
        {
            return redirect('/login');
        }
        $channelwatchlater = Wishlist::where('user_id', '=', Auth::user()->id)
            ->where('type', '=', 'channel')
            ->get();
        $ppvwatchlater = Wishlist::where('user_id', '=', Auth::user()->id)
            ->where('type', '=', 'ppv')
            ->get();

        $live_videos = Wishlist::where('user_id', '=', Auth::user()->id)
            ->where('type', '=', 'live')
            ->get();

        $episode_videos = Wishlist::where('user_id', '=', Auth::user()->id)
            ->where('episode_id', '!=', null)
            ->get();
        $channel_watchlater_array = array();

        foreach ($channelwatchlater as $key => $cfave)
        {
            array_push($channel_watchlater_array, $cfave->video_id);
        }

        $ppv_watchlater_array = array();
        foreach ($ppvwatchlater as $key => $ccfave)
        {
            array_push($ppv_watchlater_array, $ccfave->video_id);
        }

        $live_watchlater_array = array();

        foreach ($live_videos as $key => $ccfave)
        {
            array_push($live_watchlater_array, $ccfave->livestream_id);
        }

        $episode_array = array();
        
        foreach ($episode_videos as $key => $ccfave)
        {
            array_push($episode_array, $ccfave->episode_id);
        }
        $videos = Video::where('active', '=', '1')->whereIn('id', $channel_watchlater_array)->paginate(12);
        $ppvvideos = PpvVideo::where('active', '=', '1')->whereIn('id', $ppv_watchlater_array)->paginate(12);
        $livevideos = LiveStream::where('active', '=', '1')->whereIn('id', $live_watchlater_array)->paginate(12);
        $episode_videos = Episode::where('active', '=', '1')->whereIn('id', $episode_array)->paginate(12);
        // dd(count($episode_videos));
        $data = array(
            'ppvwatchlater'     =>  $ppvvideos,
            'channelwatchlater' =>  $videos,
            'livevideos'        =>  $livevideos,
            'ThumbnailSetting' => ThumbnailSetting::first(),
            'episode_videos' => $episode_videos,
        );

        return Theme::view('mywhislist', $data);

    }

    public function LiveWishlist(Request $request){

        $livestream_id = $request['livestream_id'];
        Session::flash('success', __('Password change successfully. Please Login again'));

        if ($livestream_id)
        {
            $watchlater = Wishlist::where('user_id', '=', Auth::user()->id)
                ->where('livestream_id', '=', $livestream_id)->where('type', '=', 'live')
                ->first();
            if (isset($watchlater->id))
            {
                $watchlater->delete();
                $response = "Removed From Wishlist";
                return $response;
            }
            else
            {
                $watchlater = new Wishlist;
                $watchlater->user_id = Auth::user()->id;
                $watchlater->livestream_id = $livestream_id;
                $watchlater->type = 'live';
                $watchlater->save();
                Session::flash('success', 'Product Suucess!');
                // Session::flash('success','Product Suucess!');
                $response = "Added To Wishlist";

                return $response;
             
                
            }

        }

    }

    public function episode_wishlist(Request $request)
    {

        $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();

         $Wishlist = Wishlist::where('episode_id',$request->episode_id);

         if(!Auth::guest()){
            $Wishlist = $Wishlist->where('user_id',Auth::user()->id);

         }else{
            $Wishlist = $Wishlist->where('users_ip_address', $geoip->getIP() );

         }
         $Wishlist = $Wishlist->get();

       
         if(count($Wishlist) == 0){

            Wishlist::create([
             'user_id'  => !Auth::guest() ? Auth::user()->id : null ,
             'users_ip_address'  => Auth::guest() ?  $geoip->getIP() : null ,
             'episode_id' => $request->episode_id,
             'type'     => 0,
           ]);
 
           $data = array(
             "message" => "Remove the Watch list" ,
           );
 
         }else{

            $Wishlist = Wishlist::where('episode_id',$request->episode_id);
           
            if(!Auth::guest()){
                $Wishlist = $Wishlist->where('user_id',Auth::user()->id);
    
             }else{
                $Wishlist = $Wishlist->where('users_ip_address', $geoip->getIP() );
    
             }
             $Wishlist = $Wishlist->delete();

             $data = array(
               "message" => "Add the Watch list" ,
             );
         }
          return $data ;
    }   

    public function episode_wishlist_remove(Request $request)
    {
        $geoip = new \Victorybiz\GeoIPLocation\GeoIPLocation();

        $Wishlist = Wishlist::where('episode_id',$request->episode_id);

        if(!Auth::guest()){
            $Wishlist = $Wishlist->where('user_id',Auth::user()->id);

         }else{
            $Wishlist = $Wishlist->where('users_ip_address', $geoip->getIP() );

         }
         $Wishlist = $Wishlist->delete();

        $data = array(
          "message" => "Add the Watch list" ,
        );
  
        return $data ;
    }
}